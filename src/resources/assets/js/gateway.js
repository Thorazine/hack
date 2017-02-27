// Request to api with fallback to other clusters

// prepare the call

// request($(this).prop('href'), 'DELETE').then(function(response) {
// 
// }, function(error) {
// 	console.log("Failed!", error);
// });

var request = function(url, type, data) {
	return Q.Promise(function(response, error) {
		url = (typeof url === "undefined") ? 'test' : url;
		type = (typeof type === "undefined") ? 'GET' : type;
		data = (typeof data === "undefined") ? {} : data;
		baseUrlApi = '';

		runRequest(baseUrlApi + url, type, data).then(function(successReq) {
			response(successReq);
		}, function(errorReq) {
			error(errorReq);
		});
	});
}


// run the requests
var runRequest = function(connectUrl, type, data) {
	return Q.Promise(function(successReq, errorReq) {

		jQuery.ajax({
	        url: connectUrl,
	        type: type,
	        cache: false,
	    	data: data,
			success: function(data){
		        successReq({
					success: true,
					error: false,
					data: data
				});
		    },
		    statusCode: {
			    404: function() {
			      	errorReq({ success: false, error: '404: Not found', data: null });
			    },
			    403: function() {
			      	successReq({ success: false, error: 'You are not logged in. Redirecting', data: null });
			    },
			    401: function() {
			      	errorReq({ success: false, error: '401: Credentials incorrect', data: null });
			    },
			    400: function() {
			       console.log('bad request');
			    },
			    500: function() {
			    	errorReq({ success: false, error: '500: Internal server error', data: null });
			    },
			    501: function() {
			    	errorReq({ success: false, error: '501: Gateway Timeout', data: null });
			    },
			    503: function() {
			    	errorReq({ success: false, error: '503: Not availible', data: null });
			    },
			    504: function() {
			    	errorReq({ success: false, error: '504: Gateway Timeout', data: null });
			    }
		  	},
		  	error: function() {
		  		errorReq({ success: false, error: 'something went wrong', data: null });
			}
	  	});
	});
}