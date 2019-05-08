
$(document).ready(function(){
    //Skriver ut horoskopet om det finns sparat i SESSION
    viewHoroscope = function(){
        $.ajax({
            url:"app/main/read.php",
            method: "GET",
            success: function(results){
                if(results.state == "404"){
                        $(".content").html("");
                }else{ 
                    var num = results.records.length;
                    var data = results.records;
                    var str = '';
                    if(num >0){
                        str = '<div class="init"></div>';
                        for(var i in data){
                        
                            var description = data[i].description;
                            var split = description.split("#");
                            str = str + '<div class="items no-border-top"><a href="#"  id="'+data[i].id+'" title="'+data[i].name+'" onclick="javascript:draft('+data[i].id+');">'+ split[0] +'</a>' + split[1] + '</div>';

                        }
                            $(".content").html(str);

                    }else{
                         $(".content").html("");
                    }                    
                }                

               


            }
        });
    }

    viewHoroscope();

    //Visar sparat horoskop
    $("#visaHoroskop").click(function(){
        viewHoroscope();
    });
    
    //Sparar horoskopet i SESSION och skriver ut om SESSION är tomt
    $("#sparaHoroscope").click(function(){
                
        $.ajax({
            url:"app/main/create.php",
            method: "POST",
            data:{
                "name": $("#angivetNummer").val()
            },
            success: function(results){
                if(results.state == "good"){
                    viewHoroscope();
                    $("#angivetNummer").val("");
                }else{ 
                    alert("Please insert the Horoscope");
                }
            }
        });
    });
    
    //Uppdaterar SESSION med det nya horoskopet och skriver ut
    //Ber dig sparat ett horoskop om SESSION är tomt
    $("#uppdateraHoroscope").click(function(){
                
        $.ajax({
            url:"app/main/update.php",
            method: "PUT",
            data:{
                "id": $("#realID").val(),
                "name": $("#angivetNummer").val(),
            },
            success: function(results){
                if(results.state == "good"){
                    viewHoroscope();
                    $("#angivetNummer").val("");
                }
                else { 
                    alert("Please select the item");
                }
            }
        }); 
    });
    
    //Tömmer SESSION 
    //Säger ifrån om det inte finns något sparat
    $("#raderaHoroscope").click(function(){
                
        $.ajax({
            url:"app/main/delete.php",
            method: "DELETE",
                success: function(results){
                    if(results.state == "good"){
                        viewHoroscope();
                        $("#angivetNummer").val("");
                    }
                    else { 
                        alert("Please select the item");
                    }
                }
        });   
    });

});

	function draft(id){
		var ids = "#";
		ids = ids + id;
        var title = $(""+ids+"").attr('title');
		$("#angivetNummer").val(title);
		$("#realID").val(id);

        $.ajax({
            url:"app/main/session.php",
            method: "POST",
            data:{
                "id": $("#realID").val(),
                "name": $("#angivetNummer").val()
            },
            success: function(results){
            }
        });        
	}