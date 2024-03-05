console.log("ENTRE A IMAGES");

var image_workspace = document.querySelector('.image-workspace img');
var image_workspace_2 = document.querySelector('.image-workspace-2 img');
var actionButton = document.querySelectorAll('.action-button button');
var hiddenUpload = document.querySelector('.action-button .hidden-upload');
var zoom = document.querySelectorAll('.side-control-page-1 .zoom svg');
var rotate = document.querySelectorAll('.side-control-page-1 .rotate svg');
var flip = document.querySelectorAll('.side-control-page-1 .flip svg');


actionButton[0].onclick = () => hiddenUpload.click();

hiddenUpload.onchange = () => {

    document.querySelector('.image-workspace').style.display = 'none';
    document.querySelector('.image-workspace-2').style.display = 'block';
    var file = hiddenUpload.files[0];
    console.log("file");
    var url = window.URL.createObjectURL(new Blob([file], { type : 'image/png'}))
   
    image_workspace_2.src = url;
  
    var options = {
        dragMode: 'move',
        //preview: '.img-preview',
        viewMode: 1,
        modal: false,
        background: false,
        ready: function(){
             //zoom
             zoom[0].onclick = () => crooper.zoom(0.1);
             zoom[1].onclick = () => crooper.zoom(-0.1);
            
             rotate[0].onclick = () => crooper.rotate(45);
             rotate[1].onclick = () => crooper.rotate(-45);


              //flip
              var flipX = -1;
              var flipY = -1;
              flip[0].onclick = () => {
               crooper.scale(flipX, 1)
               flipX = -flipX;
              }; 

              flip[1].onclick = () => {
               crooper.scale(1, flipY)
               flipY = -flipY;
              }; 


              document.querySelector('#descargar').onclick = () => {
                document.querySelector('#descargar').onclick.innerText = '...'
                crooper.getCroppedCanvas().toBlob((blob) => {
                    var downloadURL = window.URL.createObjectURL(blob);
                    console.log(downloadURL);
                    //document.querySelector("#edit").filename  = downloadURL;

                    /*
                    var a = document.createElement('a');
                    a.href =  downloadURL;
                    a.download = 'cropped-image.jpg';
                    a.click();
                    actionButton[1].innerText = 'Download';*/

                    var reader = new FileReader();
                    reader.readAsDataURL(blob); 
                    reader.onloadend = function() {
                    var base64data = reader.result;                
                    console.log(base64data);
                    document.querySelector("#bl").value= base64data;
                    document.querySelector('#guardar-submit').disabled = false;
                    console.log("aaaaaaaaaaaaa");
                    }
                })
               }

            
            }
    }

    var crooper = new Cropper(image_workspace_2, options);
}




/*
var image_workspace = document.querySelector('.image-workspace img');
var side_controls_shifter = document.querySelectorAll('.side-controls-shifter svg');
var side_control_page_1 = document.querySelector('.side-control-page-1');
var side_control_page_2 = document.querySelector('.side-control-page-2');
var actionButton = document.querySelectorAll('.action-button button');
var hiddenUpload = document.querySelector('.action-button .hidden-upload');
var image_workspaceSpan = document.querySelector('.image-workspace span');
var preview_containerSpan = document.querySelector('.preview-container span');

var zoom = document.querySelectorAll('.side-control-page-1 .zoom svg');
var rotate = document.querySelectorAll('.side-control-page-1 .rotate svg');
var flip = document.querySelectorAll('.side-control-page-1 .flip svg');
var move = document.querySelectorAll('.side-control-page-1 .move svg');
var aspectRadio = document.querySelectorAll('.side-control-page-2 .aspect li');
var controlCropper = document.querySelectorAll('.bottom-control .ctrl-cropper svg');
var lockCropper = document.querySelectorAll('.bottom-control .lock svg');
var dragMode = document.querySelectorAll('.bottom-control .drag-mode svg');

//Shift control page

console.log("HOLA");

side_controls_shifter[0].onclick = () =>{
    side_control_page_1.style.display = 'block';
    side_control_page_2.style.display = 'none';
    side_controls_shifter[0].classList.add('active');
    side_controls_shifter[1].classList.remove('active');
} 

side_controls_shifter[1].onclick = () =>{
    side_control_page_1.style.display = 'none';
    side_control_page_2.style.display = 'block';
    side_controls_shifter[0].classList.remove('active');
    side_controls_shifter[1].classList.add('active');
} 


//upload image

actionButton[0].onclick = () => hiddenUpload.click();
hiddenUpload.onchange = () => {
    var file = hiddenUpload.files[0];
    console.log(file);
    var url = window.URL.createObjectURL(new Blob([file], { type : 'image/jpg'}))
    image_workspace.src = url;
    image_workspaceSpan.style.display = 'none';
    preview_containerSpan.style.display = 'none';

    var options = {
        dragMode: 'move',
        preview: '.img-preview',
        viewMode: 2,
        modal: false,
        background: false,
        ready: function(){
                //zoom
                zoom[0].onclick = () => crooper.zoom(0.1);
                zoom[1].onclick = () => crooper.zoom(-0.1);


                //rotate
                rotate[0].onclick = () => crooper.rotate(45);
                rotate[1].onclick = () => crooper.rotate(-45);

                //flip
               var flipX = -1;
               var flipY = -1;
               flip[0].onclick = () => {
                crooper.scale(flipX, 1)
                flipX = -flipX;
               }; 

               flip[1].onclick = () => {
                crooper.scale(1, flipY)
                flipY = -flipY;
               }; 

                //move
                move[0].onclick = () => crooper.move(0, -1);
                move[1].onclick = () => crooper.move(-1 , 0);
                move[2].onclick = () => crooper.move(1, 0);
                move[3].onclick = () => crooper.move(0, 1);

                //aspect radio
                aspectRadio[0].onclick = ()  => crooper.setAspectRatio(1.7777777777777777);
                aspectRadio[1].onclick = ()  => crooper.setAspectRatio(1.333333333333333);
                aspectRadio[2].onclick = ()  => crooper.setAspectRatio(1);
                aspectRadio[3].onclick = ()  => crooper.setAspectRatio(0.6666666666666);
                aspectRadio[4].onclick = ()  => crooper.setAspectRatio(0);


                //copper control
               controlCropper[0].onclick = () => crooper.clear();
               controlCropper[0].onclick = () => crooper.crop();

               //lock cropper
               lockCropper[0].onclick = () => crooper.disable();
               lockCropper[1].onclick = () => crooper.enable();

               //drag mode
               dragMode[0].onclick = () => crooper.setDragMode("crop");
               dragMode[1].onclick = () => crooper.setDragMode("move");

               //download
               actionButton[1].onclick = () => {
                actionButton[1].innerText = '...'
                crooper.getCroppedCanvas().toBlob((blob) => {
                    var downloadURL = window.URL.createObjectURL(blob);
                    console.log(downloadURL);
                    document.querySelector("#edit").filename  = downloadURL;
                    var a = document.createElement('a');
                    a.href =  downloadURL;
                    a.download = 'cropped-image.jpg';
                    a.click();
                    actionButton[1].innerText = 'Download';
                })
               }
            }
    }

    var crooper = new Cropper(image_workspace, options)
}


*/

















