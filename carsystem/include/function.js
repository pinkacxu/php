
function SelectAll(action,formid,inputid){ 
    var testform=document.getElementById(formid); 
    for(var i=0 ;i<testform.elements.length;i++){ 
        if(testform.elements[i].type=="checkbox"){ 
            e=testform.elements[i]; 
			if(e.id==inputid)
			{
            if(action=="selectAll")e.checked=1;
			else if(action=="")e.checked=!e.checked;
			else if(action=="selectNo")e.checked=0;
			}
        } 
    }     
}
function checkdelform(formid,inputid){
	var testform=document.getElementById(formid); 
    for(var i=0 ;i<testform.elements.length;i++){if(testform.elements[i].type=="checkbox"){e=testform.elements[i]; if(e.checked==1&&e.id==inputid) return true;}}
	alert('データエラー');return false;
}
function ask(url){if(confirm('削除？'))location=url;}