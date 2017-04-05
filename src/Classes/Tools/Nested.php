<?php

namespace Thorazine\Hack\Classes\Tools;

class Nested {
	

	private $depth = 0;
	private $previousDepth = 0;


	public function before($index, $data, $datas)
	{
		$html = '';

		

		if($index == 0) {
			$html .= '';
		}
		elseif($data['depth'] == $this->previousDepth) { // same level
			$html .= '</li>';
		}
		elseif($data['depth'] < $this->previousDepth) { // Level(s) down
			$html .= '</li></ol></li>';

			for($i = 1; $i < ($this->previousDepth - $data['depth']); $i++) {
				$html .= '</ol></li>';
			}
		}
		elseif($data['depth'] > $this->previousDepth) { // level up
			$html .= '<ol>';
		}

		$html .= '<li id="nested_'.$data->id.'" data-name="'.$data->id.'">';

		return $html;
	}


	public function after($index, $data, $datas)
	{
		$html = '';

		if($datas->count() == $index + 1) {
			$html .= '</li>';
		}

		$this->previousDepth = $data['depth'];

		return $html;
	}

}