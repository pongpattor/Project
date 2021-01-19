$(document).ready(function () {

    // Customer Start
    function validationCustomerType() {
        var Errors = 0;
        var customerTypeName = $('#customerTypeName').val();
        var customerTypeDiscount = $('#customerTypeDiscount').val();
        var customerTypeDiscountBdate = $('#customerTypeDiscountBdate').val();
        if (customerTypeName == '') {
            $('#customerTypeNameError').html('กรุณากรอกข้อมูล');
            Errors = 1;
        } else {
            $('#customerTypeNameError').html('');
        }
        if (customerTypeDiscount == '') {
            $('#customerTypeDiscountError').html('กรุณากรอกข้อมูล');
            Errors = 1;
        } else if (customerTypeDiscount > 100) {
            $('#customerTypeDiscountError').html('กรุณากรอกข้อมูลระหว่าง0ถึง100');
            Errors = 1;
        } else {
            $('#customerTypeDiscountError').html('');
        }
        if (customerTypeDiscountBdate == '') {
            $('#customerTypeDiscountBdateError').html('กรุณากรอกข้อมูล');
            Errors = 1;
        } else if (customerTypeDiscountBdate > 100) {
            $('#customerTypeDiscountBdateError').html('กรุณากรอกข้อมูลระหว่าง0ถึง100');
            Errors = 1;
        } else {
            $('#customerTypeDiscountBdateError').html('');
        }
        return Errors;
    }

    $('#addCustomerTypeForm').on('submit', function(e) {
        e.preventDefault();
        var result = validationCustomerType();
        if (result == 0) {
            $.ajax({
                url: "insertCustomerType",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url) ;
                    } else {
                        alert(data.message);
                        $('#customerTypeNameError').html(data.message);

                    }
                }
            });
        } else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
        }
    });

    $('#editCustomerTypeForm').on('submit', function(e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validationCustomerType();
            if (result == 0) {
                $.ajax({
                    url: "updateCustomerType",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == true) {
                            alert(data.message);
                            // console.log(data);
                            location.replace(data.url) ;
                        } else {
                            alert(data.message);
                            $('#customerTypeNameError').html(data.message);
                        }
                    }
                });
            } else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
            }
        }
    });

    $('#customerTypeDiscount').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }
    });

    $('#customerTypeDiscountBdate').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }

    });

    $('.deleteCustomerType').on('click',function(){
        var customerTypeID = $(this).val();
        var cf = confirm(`ยืนยันการลบประเภทสมาชิก รหัส ${customerTypeID}`);
        if (cf == true) {
            $.ajax({
                url: "customerType/deleteCustomerType",
                method: "POST",
                data: {
                    customerTypeID: customerTypeID
                },
                success: function(data) {
                    alert(`ลบประเภทสมาชิก รหัส ${customerTypeID} เสร็จสิ้น`);
                    location.reload();
                    // console.log(data);
                }
            });
        }
    });

    function validationCustomer(){
        var Errors = 0;
        var customerFirstName = $('#customerFirstName').val();
        var customerLastName = $('#customerLastName').val();
        var customerGender = $('#customerGender').val();
        var customerBdate = $('#customerBdate').val();
        var customerAddress = $('#customerAddress').val();
        var customerProvince = $('#customerProvince').val();
        var customerAmphur = $('#customerAmphur').val();
        var customerDistrict = $('#customerDistrict').val();
        var customerPostCode = $('#customerPostCode').val();
        var customerType = $('#customerType').val();
        return Errors;
    }
    $('#addCustomerForm').on('submit',function(e){
        e.preventDefault();
        var result = validationCustomer();
        alert(result);
    });



    var addPhoneCustomer = 1;
    $('#addphone').click(function() {
        addPhoneCustomer++;
        var txt = `<tr id="row${addPhoneCustomer}">
                        <td><input type="tel" class="form-control telphone" name="tel[] minlength="10" maxlength="10" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'></td>
                        <td><button type="button" id="${addPhoneCustomer}" class="btn btn-danger btn-remove float-right">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tr>`;
        $('#bodyTel').append(txt);

        $('.btn-remove').on('click', function() {
            var btn_del = $(this).attr("id");
            $('#row' + btn_del).remove();
        });

    });


    // Customer End


    $('.bgtable').mouseover(function() {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "#C6FFF8");
    });
    $('.bgtable').mouseout(function() {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "");
    });
});