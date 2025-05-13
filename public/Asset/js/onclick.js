

function view(){
    if(localStorage.getItem('data')!=null){
        var data = JSON.parse(localStorage.getItem('data'));
        for(i=0; i<data.length; i++){
            var name = data[i].name;
            var price = data[i].price;
            var img = data[i].img;

        }
    }
}
function add_wistlist(clicked_id){
    var id=clicked_id;
    var name = document.getElementById('Product_title_'+id).title;
    var img = document.getElementById('Product_img_'+id).src;
    var price = document.getElementById('Product_price_'+id).title;
    // alert(name)
    var newItem ={
        'img ' :img,
        'name': name,
        'price':price
    }

    if(localStorage.getItem('data')== null){
        localStorage.setItem('data', '[]');

    }
    var old_data = JSON.parse(localStorage.getItem('data'));
    var matches =$.grep(old_data, function(obj){
        return obj.id == id;
    })
    if(matches.length){
        alert('Sản phẩm đã có trong mục yêu thích');

    }else{
        old_data.push(newItem);


    }




    localStorage.setItem('data', JSON.stringify(old_data));

}

function addtocart(event) {
    event.preventDefault();

    // Sử dụng this đúng cách để lấy URL
    let urlCart = $(this).data('url');

    // Kiểm tra xem URL có tồn tại không
    if (urlCart) {
        $.ajax({
            type: 'GET',
            url: urlCart,
            dataType: 'json',
            success: function (data) {
                if (data.code === 200) {
                    // Hiển thị thông báo thành công
                    alert('Thêm sản phẩm vào giỏ hàng thành công');
                } else {
                    alert('Lỗi khi thêm sản phẩm vào giỏ hàng');
                }
            },
            error: function () {
                alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    }
}
$(function()
{
   $('.updatecart').on('click',updatecart );
});
function updatecart(event){
    event.preventDefault();
    alert(hello);
    let urlDelete = $('.cartdetete').data('url');
    let id = $(this).data('id');
  $.ajax({
    type:'GET',
    url:urlDelete,
    data: {id:id},
    success:function(data){
        if(data.code ===200){
            $('.goto-here').html(data.cart_component);
            alert('Xóa sản phẩm thành công')
        }

    },
    error:function(){

    }
  });


}

function addcoupon(event){
var coupon = $('.coupon').val();
alert ($coupon);


}

$(document).ready(
)
    $(document).ready
        (function()
        {
           $('.choose').on('change',choose );
        });
        function choose(){

            var action = $(this).attr('id');
                        var matp = $(this).val();
                        var _token = $('input[name = "_token"]').val();
                        var result = '';
                        if(action=='city'){
                            result = 'province';
                        }
                        else {
                            result= 'wards';
                        }
                        // alert(url);
                        $.ajax({
                            type:'POST',
                            url:"select-delivery",
                            data:{action:action,matp:matp, _token:_token},
                            success:function(data){
                                $('#'+result).html(data);
                            }

                          });


            }

$(function()
{
   $('.addtocart').on('click',addtocart );
});



$(document).ready (function()
{
   $('.xacnhan').on('click',xacnhan );

});
function xacnhan(event){
    var submit = $("button[type='submit']");
    event.preventDefault();
    var matp = $('.city').val();
    var maqh = $('.province').val();
    var xaid  = $('#wards').val();
    var coupon  = $('.coupon').val();
    var _token = $('input[name = "_token"]').val();


    $.ajax({
        type:'POST',
        url:"tinhphi",
        data:{maqh:maqh,matp:matp, _token:_token,  xaid:xaid,  coupon:coupon},
        success:function(data){
            // $('.them').html(data);

        }
      });




// $(function()
// {
//    $('#updatecart').on('click',function cartup(event){
//     alert(hello);
// //     event.preventDefault();
// //     let urlUpdate = $('.cartupdate').data('url');
// //     let id = $(this).data('id');
// //   $.ajax({
// //     type:'GET',
// //     url:urlUpdate,
// //     data: {id:id},
// //     let quatity = $(this).parents('tr').find('input').val();
// //     alert(quatity);
// //     success:function(data){
// //         if(data.code ===200){
// //             $('.goto-here').html(data.cart_component);
// //             alert('Xóa sản phẩm thành công')
// //         }

// //     },
// //     error:function(){

// //     }
// //   });


// } );
// });

    }

