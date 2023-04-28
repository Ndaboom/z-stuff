function triggerMoment(){
    document.querySelector('#moment_media').click();
}

function momentPreview(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#previewMoment').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
