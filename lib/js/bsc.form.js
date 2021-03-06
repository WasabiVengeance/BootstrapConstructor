bsc.form={};

bsc.form.clearErrors=function(formObj){
	for(var i=0;i<formObj.elements.length;i++){
		var formElem = $(formObj.elements[i]);
		var errorParent = bsc.form.getFormGroup(formElem);
		var elemName =formElem.attr('name');
		if(elemName == '' || typeof(elemName) == 'undefined')
			elemName =formElem.attr('id');
		if(errorParent != false){
			errorParent.find('.bsc-form-error-msg[for='+elemName+']').hide();
			if(errorParent.hasClass('has-error')){
				errorParent.removeClass('has-error').addClass('has-success');
			}
		}
	}
};

bsc.form.getFormGroup=function(formItemObj){
	var formGroup = formItemObj.parent();
	var doLoop = true;
	var depthLimit = 10;
	while(doLoop){
		depthLimit--;
		if(depthLimit == 0)
			return false;
		if(formGroup.hasClass('form-group')){
			doLoop=false;
		}else{
			formGroup = formGroup.parent();
			if(formGroup.prop('tagName') == 'FORM'){
				formGroup = false;
				doLoop=false;
			}
			if(!formGroup){
				formGroup = false;
				doLoop=false;
			}
		}
	}
	return formGroup;
};

bsc.form.showErrors=function(formObj,errorList){
	var first = true;
	for(var inputName in errorList){
		//first, find the parent element with the 'form-control' class;
		var obj = $(formObj[inputName]);
		var errorParent = bsc.form.getFormGroup(obj);
		if(errorParent != false){
			var errorArea = errorParent.find('.bsc-form-error-msg[for='+inputName+']');
			if(errorArea.length < 1){
				errorParent.append('<div class="bsc-form-error-msg" for="'+inputName+'"></div>');
				errorArea = errorParent.find('.bsc-form-error-msg[for='+inputName+']');
			}
			errorArea.html(errorList[inputName]).show();
			errorParent.removeClass('has-success').addClass('has-error');
		}
		if(first && typeof(formObj[inputName].focus) == 'function'){
			formObj[inputName].focus();
			first = false;
		}
	}
};
