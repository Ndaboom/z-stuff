let image_count = 0;
function triggerClick(){
    document.querySelector('#image').click();
}

function customTrigger(){
    if(image_count == 0){
    document.querySelector("#image").click();
    image_count++;
    console.log(image_count);
    }else if(image_count == 1){
    document.querySelector("#image"+image_count).click();
    image_count++;
    console.log(image_count);
    }else if(image_count == 2){
    document.querySelector("#image"+image_count).click();
    image_count++;
    console.log(image_count);
    }
}

function triggerProduct(){
    document.querySelector("#product_image").click(); 
}

function displayProduct(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#product_preview').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            document.querySelector('#preview2').setAttribute('src', e.target.result);
            $("#preview2").show();
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function trigger(id){
    document.querySelector('#'+id).click();
}

function displayImages(e,nbre){
    
    $("#pimage"+nbre).show();
    
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#pimage'+nbre).setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }

}

function displayImage2(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#pimage2').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage3(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#pimage3').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function triggerClick1(){
    document.querySelector('#image1').click();
}

function profileTrigger(){
    document.querySelector('#profile_pic').click();
}

function coverTrigger(){
    document.querySelector('#cover_pic').click();
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

function displayPlaceCover(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#coverDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayPlaceProfile(e){
    if(e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
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
            document.querySelector('#video_player').setAttribute('src', e.target.result);
            $("#video_player").show();
            $("#post_sharing_btn").slideToggle();
            $("#video_sharing_btn").slideToggle(); 
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function videoTrigger(){
    $("#images_trigger").hide();
    document.querySelector('#file1').click();
}
