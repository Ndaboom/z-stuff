function triggerClick(){
    document.querySelector('#image').click();
}

function displayImage(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            $("#update_photos").show();
        }
        reader.readAsDataURL(e.files[0]);
    }
}
function triggerClick1(){
    document.querySelector('#image1').click();
}

function displayImage1(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplay1').setAttribute('src', e.target.result);
            $("#update_photos").show();
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function triggerClick3(){
    document.querySelector('#maudio').click();
}

function displaySound(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#audioPlayer').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function triggerClick4(){
    document.querySelector('#file1').click();
}

function displayVideo(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#videoPlayer').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
