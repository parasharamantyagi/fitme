var toastr = {
  success : function(success_message,delayTime = 3000) {
    $.toast({
          heading             : 'Success',
          text                : success_message,
          loader              : true,
          loaderBg            : '#fff',
          showHideTransition  : 'fade',
          icon                : 'success',
          hideAfter           : delayTime,
          position            : 'top-right'
      });
  },
  error : function(error_message,delayTime = 3000) {
    $.toast({
          heading             : 'Error',
          text                : error_message,
          loader              : true,
          loaderBg            : '#fff',
          showHideTransition  : 'fade',
          icon                : 'error',
          hideAfter           : delayTime,
          position            : 'top-right'
      });
  }
}

function deleteData(id,action){
	if(confirm('Are you sure to delete this ..??')){
		
		$.ajax({
				type: 'POST',
				url: '/admin/delete-data',
				dataType: 'json',
				data: {
						_token: $('meta[name="csrf-token"]').attr('content'),
						id:id,
						action:action
				},
				success: function (response) {
					
					toastr.success(response.message,response.delayTime);
					if(response.url)
					{
						if(response.delayTime)
							setTimeout(function() { window.location.href=response.url;}, response.delayTime);
						else
							window.location.href=response.url;
					}
					// if(response.success){
						
						// $('.'+current_class+' input[name="amount[]"]').val(response.amount);
						// let sum_amount = $("input[id='amount']").map(function(){return parseFloat($(this).val());}).get();
						// $("#process_to_paid").html(sum_amount.reduce((a, b) => a + b));
					// }
				}
			});
	}
}

function editData(id,action){
	
	window.location.href=action+'/'+id;
}

$('.toggle-switch').click(function() {
	let cat_id = $(this).data("id");
	let type = $(this).data("type");
	let is_check = 0;
	if ($(this).is(':checked')) {
		is_check = 1;
    }
	$.ajax({
			type: 'POST',
			url: '/admin/change-status',
			dataType: 'json',
			data: {
					_token: $('meta[name="csrf-token"]').attr('content'),
					id:cat_id,
					type:type,
					is_check:is_check
			},
			success: function (response) {
				
			}
		});
});


$('.product-category').change(function() {
	
	window.location.href= "?cat_id="+$(this).val();
	// console.log();
	
});
let in_cup_size_ID = 0;
$('button[class="pd-setting-ed plus-circle-button-add"]').click(function(){
	in_cup_size_ID++;
	let product_bra_append = '<div class="row child">';
	product_bra_append += '<input name="product_field_id[]" value="0" type="hidden">';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('select[name="Band_size_ID[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += '<label class="extra-filed">Cup size</label>';
	product_bra_append += '<select name="Cup_size_ID['+in_cup_size_ID+'][]" class="form-control" multiple="" aria-invalid="false">';
	product_bra_append += '<option value="">Select Cup size</option>';
	product_bra_append += '<option value="AA">AA</option><option value="A">A</option>';
	product_bra_append += '<option value="B">B</option><option value="C">C</option>';
	product_bra_append += '<option value="D">D</option><option value="DD">DD</option>';
	product_bra_append += '<option value="E">E</option><option value="F">F</option>';
	product_bra_append += '<option value="FF">FF</option><option value="G">G</option>';
	product_bra_append += '<option value="GG">GG</option><option value="H">H</option>';
	product_bra_append += '<option value="HH">HH</option><option value="J">J</option>';
	product_bra_append += '<option value="JJ">JJ</option><option value="K">K</option>';
	product_bra_append += '</select>';
	// product_bra_append += $('select[name="Cup_size_ID['+in_cup_size_ID+']"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('input[name="color[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('input[name="image[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('input[name="quantity[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += '<label class="extra-filed">&nbsp;</label><br/>';
	product_bra_append += '<button type="button" data-toggle="tooltip" title="" class="pd-setting-ed minus-circle-button" data-original-title="Add"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
	product_bra_append += '<button type="button" data-toggle="tooltip" title="" class="pd-setting-ed copy-circle-button" data-original-title="Copy"><i class="fa fa-clone" aria-hidden="true"></i></button>';
	product_bra_append += '</div>';
	product_bra_append += '</div>';
	$('div[class="row parent"]').after(product_bra_append);
});

$(document).on("click",'button[class="pd-setting-ed copy-circle-button"]',function() {
	let color_name = $('input[name^="color[]"]').map(function(idx, elem) {
					return $(elem).val();
				  }).get();
	let get_selected_val = $(this).closest('div.child').find('input[name="color[]"]').val();
	if(color_name.length === 2){
		$(this).closest('div.child').find('input[name="color[]"]').val(color_name[0]);
	}else{
		$(this).closest('div.child').find('input[name="color[]"]').val(color_name[2]);
	}
});

$('button[class="pd-setting-ed plus-circle-button"]').click(function(){
	let product_bra_append = '<div class="row child">';
	product_bra_append += '<input name="product_field_id[]" value="0" type="hidden">';
	product_bra_append += '<div class="col-md-3 form-group">';
	product_bra_append += $('select[name="Band_size_ID[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-3 form-group">';
	product_bra_append += $('select[name="Cup_size_ID[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('input[name="color[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-2 form-group">';
	product_bra_append += $('input[name="image[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-1 form-group">';
	product_bra_append += $('input[name="quantity[]"]').parent().html();
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-1 form-group">';
	product_bra_append += '<label>&nbsp;</label><br/>';
	product_bra_append += '<button type="button" data-toggle="tooltip" title="" class="pd-setting-ed minus-circle-button" data-original-title="Add"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
	product_bra_append += '</div>';
	product_bra_append += '</div>';
	$('div[class="row parent"]').after(product_bra_append);
});

$('button[class="pd-setting-ed plus-circle-button-multi_image"]').click(function(){
	let product_bra_append = '<div class="row child">';
	product_bra_append += '<div class="col-md-4 form-group">';
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-4 form-group">';
	product_bra_append += '<input class="form-control" name="productField_id[]" type="hidden" value="'+$(this).data('id')+'">';
	product_bra_append += '<input class="form-control" name="images[]" type="file" aria-invalid="false">';
	product_bra_append += '</div>';
	product_bra_append += '<div class="col-md-4 form-group">';
	product_bra_append += '<button type="button" data-toggle="tooltip" data-id="'+$(this).data('id')+'" title="" class="pd-setting-ed minus-circle-button" data-original-title="Add"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
	product_bra_append += '</div>';
	product_bra_append += '</div>';
	$('div[class="row parent_'+$(this).data('id')+'"]').after(product_bra_append);
});

$(document).on("click",'button[class="pd-setting-ed minus-circle-button"]',function() {
	$(this).parent().parent().remove();
});
	