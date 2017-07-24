$( document ).ready(function() {
  $("#voucherExampleCupon").hide(); //hides the table when loading results
  $.ajax({
    type: "GET",
    url:" https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=1?token=B73AE30C600218523B4DE65A97C01A8309535FD5",//test token
    //url: "https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=1?token=6913146397DAB113DEE823AFB898429738E1A4AE", //request to Tradedoubler. This is our token.
    dataType: "json",
    success: function (data) {
      var now = new Date();
      var hits = data.length;
      if (hits==0) {
          //no hits :(
          var div=document.createElement("div");
            div.className = "col-md-12";
            div.innerHTML = "No se han encontrado cupones :(";

          document.getElementById("voucherCupon").appendChild(div);
      } else {
        for (var i=0; i<11; i++) { //loop through vouchers
          var div=document.createElement("div");
          div.className = "col-md-3";
            for (var x=0; x<2; x++) { //create a td for each value we want to present
              var url = data[i].defaultTrackUri;
              //console.log(data[i].id);

              if(data[i].endDate < now){
                div.innerHTML = "<div class=\"caducado\"><a href=\""+url+"\" target=\"_blank\"><img src=\"http://localhost/ClubEnko/public/img/oferta-caducada.png\"></a></div>"
                +"<div class=\"promo\"><div class=\"brand\"><div class=\"logo-tienda\"><a><img src=\""+data[i].logoPath+"\" width=\"120px\"></a></div></div>"
                +" <a href=\""+data[i].defaultTrackUri+"\" target=\"_blank\"><img src=\"http://localhost/ClubEnko/public/img/taller.png\"></a>"
                +"<div class=\"datos-cupon\">"
                +"<div class=\"tipo-descuento\"><p>"+data[i].discountAmount+"%</p></div>"
                +"<div class=\"datos-descuento\"><p class=\"cupon-titulo\">"+data[i].title+"</p><p class=\"cupon-descripcion\">"+data[i].code+"</p></div>"; break;  
              }else{
                div.innerHTML =   "<div class=\"promo\"><div class=\"brand\"><div class=\"logo-tienda\"><a><img src=\""+data[i].logoPath+"\" width=\"120px\"></a></div></div>"
                +" <a onclick=\"cupon("+data[i].id+")\" ><img src=\"/img/cenar.png\"></a>"
                +"<div class=\"datos-cupon\">"
                +"<div class=\"datos-descuento\"><p class=\"cupon-titulo\">"+data[i].title+"</p><p class=\"cupon-descripcion\">"+data[i].id+"</p></div>"; break;     
              }
  
            }
          document.getElementById("voucherCupon").appendChild(div);
        }
      }
      $("#voucherExampleCupon").fadeIn(); //show table when done
    }
  });


  $("#caja-cupon").hide();
  $.ajax({
    type: "GET",
    url: "https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=1;id=370423?token=B73AE30C600218523B4DE65A97C01A8309535FD5",//test token
    //url: "https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=1?token=6913146397DAB113DEE823AFB898429738E1A4AE", //request to Tradedoubler. This is our token.
    dataType: "json",
    success: function (data) {
      var now = new Date();
      var hits = data.length;
      if (hits==0) {
          //no hits :(
          var div=document.createElement("div");
            div.className = "col-md-12";
            div.innerHTML = "No se han encontrado cupones :(";

          document.getElementById("cupon").appendChild(div);
      } else {
        for (var i=0; i<11; i++) { //l
        console.log(data[i].title);
          var div=document.createElement("div");
            div.className = "col-md-12";
              var url = data[i].defaultTrackUri;

              if(data.endDate < now){
                }else{
                div.innerHTML =  "<div class=\"promo\">"
                                  +"<div class=\"brand\">"
                                    +"<div class=\"logo-tienda\">"
                                      +"<a><img src=\""+data[i].logoPath+"\" width=\"120px\"></a>"
                                    +"</div>"
                                  +"</div>"
                                  +"<a ><img src=\"img/cenar.png\"></a>"
                                  +"<div class=\"datos-cupon\">"
                                    +"<div class=\"datos-descuento\">"
                                      +"<p class=\"cupon-titulo\">"+data[i].title+"</p>"
                                      +"<p class=\"cupon-descripcion\">"+data[i].id+"</p>"
                                    +"</div>";     
              }

            }
          $("#cupon").append(div);
      }
      $("#caja-cupon").fadeIn(); //show table when done

    }
  });
}); 
