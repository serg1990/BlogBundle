
jQuery(document).ready(function(){
    action = new Actions();
    
    $(".delTr").click(function(){
        var id = $(this).attr("id");
        action.deleteMenu(id);
        
    })
    
    $(".title").dblclick(function(){
        var id = $(this).attr("id");
        var name = $(this).attr("name");
        
        $(this).hide();
        $(".inpc[id='"+id+"'][name='"+name+"']").show();
        $(".inpcC[id='"+id+"'][name='"+name+"']").show();
        $(".inpcV[id='"+id+"'][name='"+name+"']").show();
        
    })
    
    $(".inpc").blur(function(){
        var id = $(this).attr("id");
        var name = $(this).attr("name");
         var value = $(this).val();
        
       
        
        action.changeMenu(id,name,value,0);
    })
    $(".inpcC").change(function(){
        var id = $(this).attr("id");
        var name = $(this).attr("name");
         var value = $(this).prop("checked");
         
        action.changeMenu(id,name,value,1);
    })
    $(".inpcV").change(function(){
        var id = $(this).attr("id");
        var name = $(this).attr("name");
         var value = $(this).prop("checked");
         
        action.changeMenu(id,name,value,2);
    })
    
    
   
})

function Actions(id){
    
    var that = this;
    
    this.deleteMenu = function(id){
        if(confirm("Подтверждение")){
             $(".ajax-loader").show();
            var adminform = $("#adminform").attr('action');
            $.ajax({
            type: "POST",
            url: adminform,
            data: {id:id,formname:"del"},
            
            success: function(txt){
               $(".menuTr[id='"+id+"']").remove();
                $(".ajax-loader").hide();
            }
          });
            
            
        }
     }
     
     this.changeMenu = function(id,name,value,num){
        if(confirm("Подтверждение")){
            $(".ajax-loader").show();
            var adminform = $("#adminform").attr('action');
            $.ajax({
            type: "POST",
            url: adminform,
            data: {id:id,name:name,value:value,formname:"change"},
            
            success: function(txt){
                $(".ajax-loader").hide();
                
                switch(num){
                    case 0:
                         $(".inpc[id='"+id+"'][name='"+name+"']").hide();
                         $(".title[id='"+id+"'][name='"+name+"']").text(value).show();
                        
                        break;
                    case 1:
                         $(".inpcC[id='"+id+"'][name='"+name+"']").hide();
                         if(value)
                         {
                             var res = "Да";
                         }
                         else
                         {
                              var res = "Нет";
                         }
                         
                         $(".title[id='"+id+"'][name='"+name+"']").text(res).show();
                        
                        break;
                        case 2:
                         $(".inpcV[id='"+id+"'][name='"+name+"']").hide();
                         if(value == 'l')
                         {
                             var res = "Вертикально";
                         }
                         else
                         {
                              var res = "Горизонтально";
                         }
                         
                         $(".title[id='"+id+"'][name='"+name+"']").text(res).show();
                        
                        break;
                }
             
                
               
            }
          });
            
            
        }
        else
        {
            $(".inpcV[id='"+id+"'][name='"+name+"']").hide();
            $(".inpcC[id='"+id+"'][name='"+name+"']").hide();
            $(".inpc[id='"+id+"'][name='"+name+"']").hide();
            $(".title[id='"+id+"'][name='"+name+"']").show();
        }
     }
    
    
}

