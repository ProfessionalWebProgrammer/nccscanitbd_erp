 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script> 
<script>
    
        $(document).ready(function() {
          
          
          
		var checkedvalue = 	$("input[name='flexRadioDefault']:checked").val();
          
          if(checkedvalue == "defaultmood"){
               console.log(category);
          			$(".navbar-white").addClass('defaultmood');
                	$(".navbar-white").removeClass('darkmood');
            
            	$(".hover_manu_content").addClass('defaultmood');
                	$(".hover_manu_content").removeClass('darkmood');
               
               
                	$(".content-wrapper .content").addClass('defaultmood');
                $(".content-wrapper .content").removeClass('darkmood');
               
               
               $(".content-wrapper .container").removeClass('darkmood');
                $(".content-wrapper .container-fluid").removeClass('darkmood');
                $(".content-wrapper .container").addClass('defaultmood');
                $(".content-wrapper .container-fluid").addClass('defaultmood');
               
               
               		
               
              }else if(checkedvalue == "darkmood"){
				$(".navbar-white").removeClass('defaultmood');
                $(".navbar-white").addClass('darkmood');
                
                $(".hover_manu_content").removeClass('defaultmood');
                $(".hover_manu_content").addClass('darkmood');
                
                $(".content-wrapper .content").addClass('darkmood');
                	$(".content-wrapper .content").removeClass('defaultmood');
                
                 $(".content-wrapper .container").addClass('darkmood');
                $(".content-wrapper .container-fluid").addClass('darkmood');
                $(".content-wrapper .container").removeClass('defaultmood');
                $(".content-wrapper .container-fluid").removeClass('defaultmood');
                
                
                
              }else{
				$(".navbar-white").removeClass('defaultmood');
                $(".navbar-white").removeClass('darkmood');
                
                  $(".hover_manu_content").removeClass('defaultmood');
                $(".hover_manu_content").removeClass('darkmood');
                
                $(".content-wrapper .content").removeClass('darkmood');
                $(".content-wrapper .content").removeClass('defaultmood');
                
                $(".content-wrapper .container").removeClass('darkmood');
                $(".content-wrapper .container-fluid").removeClass('darkmood');
                $(".content-wrapper .container").removeClass('defaultmood');
                $(".content-wrapper .container-fluid").removeClass('defaultmood');
                

              }
          var category = null;
          $("input[name='flexRadioDefault']").click(function() {
              category = this.value;
            
             if(category == "defaultmood"){
               console.log(category);
          			$(".navbar-white").addClass('defaultmood');
                	$(".navbar-white").removeClass('darkmood');
               
                   $(".hover_manu_content").addClass('defaultmood');
                $(".hover_manu_content").removeClass('darkmood');
               
                	$(".content-wrapper .content").addClass('defaultmood');
                $(".content-wrapper .content").removeClass('darkmood');
               
               
               $(".content-wrapper .container").removeClass('darkmood');
                $(".content-wrapper .container-fluid").removeClass('darkmood');
                $(".content-wrapper .container").addClass('defaultmood');
                $(".content-wrapper .container-fluid").addClass('defaultmood');
               
               
               		
               
              }else if(category == "darkmood"){
				$(".navbar-white").removeClass('defaultmood');
                $(".navbar-white").addClass('darkmood');
                
                    $(".hover_manu_content").removeClass('defaultmood');
                $(".hover_manu_content").addClass('darkmood');
                
                $(".content-wrapper .content").addClass('darkmood');
                	$(".content-wrapper .content").removeClass('defaultmood');
                
                 $(".content-wrapper .container").addClass('darkmood');
                $(".content-wrapper .container-fluid").addClass('darkmood');
                $(".content-wrapper .container").removeClass('defaultmood');
                $(".content-wrapper .container-fluid").removeClass('defaultmood');
                
                
                
              }else{
				$(".navbar-white").removeClass('defaultmood');
                $(".navbar-white").removeClass('darkmood');
                
                    $(".hover_manu_content").removeClass('defaultmood');
                $(".hover_manu_content").removeClass('darkmood');
                
                $(".content-wrapper .content").removeClass('darkmood');
                $(".content-wrapper .content").removeClass('defaultmood');
                
                $(".content-wrapper .container").removeClass('darkmood');
                $(".content-wrapper .container-fluid").removeClass('darkmood');
                $(".content-wrapper .container").removeClass('defaultmood');
                $(".content-wrapper .container-fluid").removeClass('defaultmood');
                

              }
            
          });
          
          
          
        });
     
  </script>