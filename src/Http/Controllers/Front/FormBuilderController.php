<?php

namespace Thorazine\Hack\Http\Controllers\Front;

use Thorazine\Hack\Http\Requests\FormBuilderStore;
use Thorazine\Hack\Models\FormEntry;
use Thorazine\Hack\Models\FormValue;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Form;
use Illuminate\Http\Request;
use Cms;
use App;

class FormBuilderController extends Controller
{
    

    public function __construct(Form $form, FormEntry $formEntry, FormValue $formValue)
    {
        $this->form = $form;
        $this->formEntry = $formEntry;
        $this->formValue = $formValue;
    }


    public function store(FormBuilderStore $request)
    {
        $form = Form::find($request->id)
            ->with('formFields')
            ->first();

        // find the fields that need to be inserted
        $fields = [];
        foreach($form->formFields as $formField) {
            $fields[$formField['key']] = $formField;
        }
        $inputs = $request->only(array_keys($fields));

        // create a response entry
        $entryId = $this->formEntry->insertGetId([
            'form_id' => $request->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $inserts = [];
        foreach($inputs as $key => $input) {
            array_push($inserts, [
                'form_entry_id' => $entryId,
                'form_field_id' => $fields[$key]->id,
                'form_id' => $request->id,
                'value' => $input,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->formValue->insert($inserts);

        // handle the on complete function
        if($form->on_complete_function && class_exists($form->on_complete_function)) {
            
            $class = new $form->on_complete_function();

            $class->fire($form, $inputs);
        }

        return redirect()->back()
            ->with('thank', $form->thank_message);
    }


    private function sendMail($form)
    {
        if($form->email_new) {
            Mail::send($form->email_template, ['form' => $form, 'inputs' => $inputs], function ($m) use ($form) {
                $m->from($form->email_from, $form->email_from_name);
                $m->replyTo($form->email_reply_to, $form->email_reply_to_name);
                foreach(explode(',', $form->email_to) as $to) {
                    $m->to($to);
                }
                $m->subject($form->email_subject);
            });
        }
    }
}
