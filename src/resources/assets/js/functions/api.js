import axios from 'axios'
import asset from './asset.js';

const api = {
    // docGet (data) {
    //     return axios.get(asset('api/documents/get'), {params: data});
    // },
    mediaGet(data) {
    	return axios.get('http://localhost/wysiwyg/public/api/media', {params: data});
    },
    mediaEdit(data) {
    	return axios.get('http://localhost/wysiwyg/public/api/media/edit', {params: data});
    },
    mediaUpdate(data) {
    	return axios.post('http://localhost/wysiwyg/public/api/media/update', data);
    },
    mediaResize(data) {
    	return axios.post('http://localhost/wysiwyg/public/api/media/resize', data);
    }
}

export default api;
