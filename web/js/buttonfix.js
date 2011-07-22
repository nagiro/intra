/*
function buttonfix(){
    $('button').click(function(){        
        $('BUTTON').each(function(k,v){
            this.disabled = true;
            this.value = this.getNamedItem('value').nodeValue;                                                 
        }); 
        this.disabled = false;
    });
}

$(document).ready(buttonfix);
*/

function buttonfix() {
    var buttons = document.getElementsByTagName('button');
    for (var i=0; i<buttons.length; i++) {
        if(buttons[i].onclick) continue;
        
        buttons[i].onclick = function () {
            for(j=0; j<this.form.elements.length; j++)
                if( this.form.elements[j].tagName == 'BUTTON' )
                    this.form.elements[j].disabled = true;
            this.disabled=false;
            this.value = this.attributes.getNamedItem("value").nodeValue ;
        }
    }
}

$(document).ready(buttonfix);
