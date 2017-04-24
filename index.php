<?php
include "./functions.php";
$link = dbConnect();
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TEST</title>
	<link rel="stylesheet" href="/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://testwork.atspace.cc/dist/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	
	<link rel="stylesheet" href="http://testwork.atspace.cc/dist/css/custom.css">
	
	<script src="http://testwork.atspace.cc/dist/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="http://testwork.atspace.cc/dist/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="http://testwork.atspace.cc/dist/js/dataTables.bootstrap.min.js"></script>
	
	
	
</head>
<body>
<script language="javascript">
$(document).ready(function(){
	
	<?php
if(isset($_GET["nameedit"]))
{
	?>
	$('.editshow').show();
	$('.edithide').hide();
	<?php
}
else 
{
		?>
	$('.editshow').hide();
	$('.edithide').show();
	<?php
}
?>
	
	$('#user').DataTable( {
	"order": [[ 1, "desc" ]],
	"columns": [
		null,
		null,
		null,
		null,
		{ "orderable": false , "targets": 0 },
		null
		],
	"columnDefs": [
		{
			"targets": [ 5 ],
            "visible": false,
            "searchable": false
        }
	  ]
} );



var table = $('#user').DataTable();
$('#user tbody').on( 'click', 'i.delete', function () {
	var data = table.row( $(this).parents('tr') ).data();
	$.post("functions.php", { type: 'forjava', id: data[5], action: 'del'});
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
	alert("Данные удалены.");
	
} );
	
 $('#user tbody').on( 'click', 'i.edit', function () {
	var data = table.row( $(this).parents('tr') ).data();
	window.location.href = 'index.php?idedit='+data[5]+'&nameedit='+data[0]+'&lastnameedit='+data[1]+'&ageedit='+data[2]+'&emailedit='+data[3]+'';
} );	
	
	$( "#creat" ).on( "click", function () 
	{
	 $.post("functions.php", { type: 'forjava', action: 'create', name: $('#name').val(), lastname: $('#lastname').val(),age: $('#age').val(),email: $('#email').val()});	
	alert ('Созданно!');
	$('#name').val('');
	$('#lastname').val('');
	$('#age').val('1');
	$('#email').val('');
	window.location.href = 'index.php';
	});
	
	
	
	$( "#save" ).on( "click", function () 
	{
	 $.post("functions.php", { type: 'forjava', action: 'edit',id: $('#idedit').val(), name: $('#name').val(), lastname: $('#lastname').val(),age: $('#age').val(),email: $('#email').val()});	
	setTimeout(function()
		{
		window.location.href = 'index.php';
		}, 100);
	
	});
	
});
</script>
<?php
if(isset($_GET["nameedit"]))
{
	$nameedit = $_GET["nameedit"];
	$lastnameedit = $_GET["lastnameedit"];
	$ageedit = $_GET["ageedit"];
	$emailedit = $_GET["emailedit"];
	$idediredit = $_GET["idedit"];
}
else 
{
	$nameedit='';
	$lastnameedit = '';
	$ageedit = '1';
	$emailedit = '';
	$idediredit ='';
}
?>
<div>
	<p>Имя:<br>
	<input id="name" value = "<?php echo $nameedit; ?>"></p>
	<p>Фамилия:<br>
	<input id="lastname" value = "<?php echo $lastnameedit; ?>"></p>
	<p>Возраст:<br>
	<input id="age" type="number" value = "<?php echo $ageedit; ?>"></p>
	<p>email:<br>
	<input id="email" type="email" value = "<?php echo $emailedit; ?>"></p>
	<input id="idedit" style="display:none" value = "<?php echo $idediredit; ?>">
	<div class="edithide">
	<button type="button" id="creat" name="creat" >Добавить</button>
	</div>
	<div class="editshow">
	<button type="button" id="save" name="save" >Сохранить</button>
	</div>
</div>
<div style='width:80%;'>
<br>
<table id='user' class='table table-striped table-bordered tableBG' style='width:100%;'>
							<thead>
							<tr>
								<th class='center'>Имя</th>
								<th class='center'>Фамилия</th>
								<th class='center'>Возраст</th>
								<th class='center'>mail</th>
								<th class='center'>Действия</th>
								<th class='center'>ID</th>
							</tr>
							</thead>
							<tbody class='tbody'>
							<?php		
								listoftable($link);
							?>
							</tbody>
							</table>
</div>
</body>
</html>