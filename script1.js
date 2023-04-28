function triggerClick1(){
    document.querySelector('#image1').click();
}

function displayImage1(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplay1').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}