$(document).ready(function(){

	getCategories();
	
	function getCategories(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_CATEGORIES:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				var brandHTML = '';

				$.each(resp.message, function(index, value){
					brandHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.cat_title +'</td>'+
									'<td><a class="btn btn-sm btn-info edit-category"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a cid="'+value.cat_id+'" class="btn btn-sm btn-danger delete-category"><i class="fas fa-trash-alt"></i></a></td>'+
								'</tr>';
				});

				$("#category_list").html(brandHTML);

			}
		})
		
	}

	$(".add-category").on("click", function(){

		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#add-category-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getCategories();
					alert(resp.message);
				}else if(resp.status == 303){
					alert(resp.message);
				}
				$("#add_category_modal").modal('hide');
			}
		})

	});

	$(document.body).on("click", ".edit-category", function(){

		var cat = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='e_cat_title']").val(cat.cat_title);
		$("input[name='cat_id']").val(cat.cat_id);

		$("#edit_category_modal").modal('show');

		

	});

	$(".edit-category-btn").on('click', function(){

		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#edit-category-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getCategories();
					alert(resp.message);
				}else if(resp.status == 303){
					alert(resp.message);
				}
				$("#edit_category_modal").modal('hide');
			}
		})

	});

	$(document.body).on('click', '.delete-category', function(){

		var cid = $(this).attr('cid');

		if (confirm("Are you sure to delete this category")) {
			$.ajax({
				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {DELETE_CATEGORY:1, cid:cid},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						alert(resp.message);
						getCategories();
					}else if(resp.status == 303){
						alert(resp.message);
					}
				}
			})
		}else{
			alert('Cancelled');
		}

		

	});

});