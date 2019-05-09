
$(document).ready(function(){
            
    //Skriver ut horoskopet om det finns sparat i SESSION
    viewHoroscope = function(){
        $.ajax({
            url:"app/main/viewHoroscope.php",
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
                            str = str + '<div class="items no-border-top"><a href="#" id="'+data[i].no+'" title="'+data[i].ID+'" onclick="javascript:draft('+data[i].no+');">'+ split[0] +'</a>' + split[1] + '</div>';

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
    //Om det redan finns ett horoskop sparat i SESSION säger den ifrån
    $("#sparaHoroscope").click(function(){
                
        $.ajax({
            url:"app/main/addHoroscope.php",
            method: "POST",
            data:{
                "ID": $("#angivetNummer").val()
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
            url:"app/main/updateHoroscope.php",
            method: "PUT",
            data:{
                "no": $("#realID").val(),
                "ID": $("#angivetNummer").val(),
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
            url:"app/main/deleteHoroscope.php",
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
                "no": $("#realID").val(),
                "ID": $("#angivetNummer").val()
            },
            success: function(results){
            }
        });        
	}