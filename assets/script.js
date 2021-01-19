$(document).ready(function () {

    function validate() {
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

    $('#formCustomerType').on('submit', function (e) {
        e.preventDefault();
        var validTrue = validate();
        if (validTrue == 0) {
            $.ajax({
                url: "<?=site_url('admin/customertype/insertCustomerType')?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status == true) {
                        alert(data.message);
                        window.location.href = "<?=site_url('admin/customertype')?>";
                    }
                    else {
                        alert(data.message);
                        $('#customerTypeNameError').html(data.message);

                    }
                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
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
});