var boton = document.getElementById('add-button');
const last = document.getElementById('photos-container');

var aux = 0;

boton.addEventListener('click', ()=>{
    aux++;
    if (aux>=10){

      alert("You cannot add more photos. Maximum: 10");

    }else{
      const divOne = document.createElement("div");
      divOne.className = "photo p-5 my-4";
      
      const labelOne = document.createElement("label");
      labelOne.htmlFor = "description";
      labelOne.style = "color: #e4e4e4";
        let labelContent = document.createTextNode("Write a short resume of this picture");
        labelOne.appendChild(labelContent);

      const divTwo = document.createElement("div");
        const textArea = document.createElement("textarea");
        textArea.className = "form-control";
        textArea.name = "description["+aux+"][description]";
        textArea.rows = "2";
        textArea.required = true;
        divTwo.appendChild(textArea);

      const divThree = document.createElement("div");
      divThree.className = "mx-auto";
      divThree.style = "width: auto; height: auto;";
        const labelTwo = document.createElement("label");
        labelTwo.className = "dropimage";
          const input = document.createElement("input");
          input.title= "Drop image or click me";
          input.type = "file";
          input.name = "photo["+aux+"][photo]";
          labelTwo.appendChild(input);
        divThree.appendChild(labelTwo);

      divOne.appendChild(labelOne);
      divOne.appendChild(divTwo);
      divOne.appendChild(divThree);

      last.appendChild(divOne);
    }

    [].forEach.call(document.querySelectorAll('.dropimage'), function(img){
      img.onchange = function(e){
        var inputfile = this, reader = new FileReader();
        reader.onloadend = function(){
          inputfile.style['background-image'] = 'url('+reader.result+')';
        }
        reader.readAsDataURL(e.target.files[0]);
      }
    });


    
  });




  /*   parrafo.innerHTML = "<div class = 'photo bg-dark p-5 my-4'><label for='description'>Write a short resume of this picture</label><div><textarea name='description' rows='2'></textarea></div><div class = 'my-4 mx-auto' style='width: 700px; height: 500px;'><label class='dropimage' style='width: 700px; height: 500px;'><input title='Drop image or click me' type='file' name = 'photo'></label></div></div>"; 
  
    document.addEventListener("DOMContentLoaded", function() {
    [].forEach.call(document.querySelectorAll('.dropimage'), function(img){
      img.onchange = function(e){
        var inputfile = this, reader = new FileReader();
        reader.onloadend = function(){
          inputfile.style['background-image'] = 'url('+reader.result+')';
        }
        reader.readAsDataURL(e.target.files[0]);
      }
    });
  });
  
  
  
  */