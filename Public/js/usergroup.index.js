	//动态添加select中的项option:
	function changeOption(){  	  
          var table = document.getElementById('paritem').value;
          if(table=='admin_group') {
               document.getElementById('sub_admin').style.display="block";
               document.getElementById('sub_special').style.display="none";
               document.getElementById('sub_level').style.display="none";
          }
          else if(table=='special_group'){
               document.getElementById('sub_admin').style.display="none";
               document.getElementById('sub_special').style.display="block";
               document.getElementById('sub_level').style.display="none";
          }
          else{
               document.getElementById('sub_admin').style.display="none";
               document.getElementById('sub_special').style.display="none";
               document.getElementById('sub_level').style.display="block";
          }
     }
