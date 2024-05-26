function show(){
    alert("fffff");
    
}
function en_dis_able(input_box,check_state){
    var text_box=$(input_box);
    var check=$(check_state).is(":checked");    
    if(check){check=false;}else{check=true;}
    text_box.prop("disabled",check);
}
function load(input_box){
    alert("h");
    var text_box=$(input_box);
    
    text_box.prop("disabled",false);
}