//All customer
$(document).ready(function () {
    //customerType
    function validationCustomerType() {
        var Errors = 0;
        var customerTypeName = $('#customerTypeName').val();
        var customerTypeDiscount = $('#customerTypeDiscount').val();
        var customerTypeDiscountBdate = $('#customerTypeDiscountBdate').val();
        if (customerTypeName == '') {
            $('#customerTypeNameError').html('กรุณากรอกชื่อประเภท');
            Errors = 1;
        } else {
            $('#customerTypeNameError').html('');
        }
        if (customerTypeDiscount == '') {
            $('#customerTypeDiscountError').html('กรุณากรอกส่วนลด');
            Errors = 1;
        } else if (customerTypeDiscount > 100) {
            $('#customerTypeDiscountError').html('กรุณากรอกข้อมูลระหว่าง0ถึง100');
            Errors = 1;
        } else {
            $('#customerTypeDiscountError').html('');
        }
        if (customerTypeDiscountBdate == '') {
            $('#customerTypeDiscountBdateError').html('กรุณากรอกส่วนลดวันเกิด');
            Errors = 1;
        } else if (customerTypeDiscountBdate > 100) {
            $('#customerTypeDiscountBdateError').html('กรุณากรอกข้อมูลระหว่าง0ถึง100');
            Errors = 1;
        } else {
            $('#customerTypeDiscountBdateError').html('');
        }
        return Errors;
    }

    $('#addCustomerTypeForm').on('submit', function (e) {
        e.preventDefault();
        var result = validationCustomerType();
        if (result == 0) {
            $.ajax({
                url: "../customerType/insertCustomerType",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status == true) {
                        // console.log(data.message);
                        alert(data.message);
                        location.replace(data.url);
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

    $('#editCustomerTypeForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validationCustomerType();
            if (result == 0) {
                $.ajax({
                    url: "../customertype/updateCustomerType",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        if (data.status == true) {
                            alert(data.message);
                            // console.log(data);
                            location.replace(data.url);
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

    // ใช้ input number แทน
    // $('#customerTypeDiscount').on('keypress', function (e) {
    //     if (e.charCode >= 48 && e.charCode <= 57) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // });

    // $('#customerTypeDiscountBdate').on('keypress', function (e) {
    //     if (e.charCode >= 48 && e.charCode <= 57) {
    //         return true;
    //     } else {
    //         return false;
    //     }

    // });

    $('.deleteCustomerType').on('click', function () {
        var customerTypeID = $(this).val();
        var cf = confirm(`ยืนยันการลบประเภทสมาชิก รหัส ${customerTypeID}`);
        if (cf == true) {
            $.ajax({
                url: "../customerType/deleteCustomerType",
                method: "POST",
                data: {
                    customerTypeID: customerTypeID
                },
                success: function () {
                    alert(`ลบประเภทสมาชิก รหัส ${customerTypeID} เสร็จสิ้น`);
                    location.reload();
                    // console.log(data);
                }
            });
        }
    });


    //customer
    function validationCustomer() {
        var Errors = 0;
        var customerFirstName = $('#customerFirstName').val();
        var customerLastName = $('#customerLastName').val();
        var customerGender = $('#customerGender').val();
        var customerBdate = $('#customerBdate').val();
        var customerAddress = $('#customerAddress').val();
        var customerProvince = $('#province').val();
        var customerAmphur = $('#amphur').val();
        var customerDistrict = $('#district').val();
        var customerPostCode = $('#postcode').val();
        var customerType = $('#customerType').val();
        var customerIdCard = $('#customerIdCard').val();

        if (customerIdCard.length != 13) {
            $('#customerIdCardError').html('กรุณากรอกเลขบัตรปราชาชนให้ครบ 13 หลัก');
            Errors = 1;
        }
        else {
            $('#customerIdCardError').html('');
        }
        if (customerFirstName == '') {
            $('#customerFirstNameError').html('กรุณากรอกชื่อ');
            Errors = 1;
        }
        else {
            $('#customerFirstNameError').html('');
        }
        if (customerLastName == '') {
            $('#customerLastNameError').html('กรุณากรอกนามสกุล');
            Errors = 1;
        }
        else {
            $('#customerLastNameError').html('');
        }
        if (customerGender == '') {
            $('#customerGenderError').html('กรุณาเลือกเพศ');
            Errors = 1;
        }
        else {
            $('#customerGenderError').html('');
        }
        if (customerBdate == '') {
            $('#customerBdateError').html('กรุณาเลือกวันเกิด');
            Errors = 1;
        }
        else {
            $('#customerBdateError').html('');
        }
        if (customerAddress == '') {
            $('#customerAddressError').html('กรุณากรอกที่อยู่');
            Errors = 1;
        }
        else {
            $('#customerAddressError').html('');
        }
        if (customerProvince == '') {
            $('#provinceError').html('กรุณาเลือกจังหวัด');
            Errors = 1;
        }
        else {
            $('#provinceError').html('');
        }
        if (customerAmphur == '') {
            $('#amphurError').html('กรุณาเลือกเขต');
            Errors = 1;
        }
        else {
            $('#amphurError').html('');
        }
        if (customerDistrict == '') {
            $('#districtError').html('กรุณาเลือกแขวง');
            Errors = 1;
        }
        else {
            $('#districtError').html('');
        }
        if (customerPostCode == '') {
            $('#postcodeError').html('กรุณาเลือกรหัสไปรษณีย์');
            Errors = 1;
        }
        else {
            $('#postcodeError').html('');
        }
        if (customerType == '') {
            $('#customerTypeError').html('กรุณาเลือกประเภทสมาชิก');
            Errors = 1;
        }
        else {
            $('#customerTypeError').html('');
        }
        var telList = [];
        var breaker = 0;
        $('input[type="tel"]').each(function () {
            var telephon = $(this).val();
            telList.push(telephon);
        });
        for (var i = 0; i < telList.length; i++) {
            for (var j = 0; j < telList.length; j++) {
                if (telList[i].length != 10) {
                    $('#customerTelError').html('กรุณากรอกเบอร์โทรให้ครบ 10 หลัก');
                    Errors = 1;
                    breaker = 1;
                    break;
                }
                else {
                    if (i == j) {
                        // console.log('continue');
                        continue;
                    } else if (telList[i] == telList[j]) {
                        // console.log(i + " :" + telList[i] + ": " + telList[j] + ': Found same');
                        $('#customerTelError').html('กรุณาอย่ากรอกเบอร์ซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
            }
            if (breaker == 1) {
                break;
            } else {
                $('#customerTelError').html('');
            }
        }
        return Errors;
    }

    $('#addCustomerForm').on('submit', function (e) {
        e.preventDefault();
        var result = validationCustomer();
        if (result == 0) {
            $.ajax({
                url: "../customer/insertCustomer",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.errorTel == '') {
                            $('#customerTelError').html('');
                        }
                        else {
                            $('#customerTelError').html(data.errorTel);
                        }
                        if (data.errorIdCard == '') {
                            $('#customerIdCardError').html('');
                        }
                        else {
                            $('#customerIdCardError').html(data.errorIdCard);
                        }
                        alert(data.message);
                    }

                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง');   
        }
    });

    var addCustomerTel = 1;
    $('#addCustomerTel').click(function () {
        addCustomerTel++;
        var txt = `<tr id="row${addCustomerTel}">
                        <td><input type="tel" class="form-control customerTel" name="customerTel[]" maxlength="10"></td>
                        <td><button type="button" id="${addCustomerTel}" class="btn btn-danger btn-remove float-right">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tr>`;
        $('#bodyTel').append(txt);

        $('.btn-remove').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#row' + btn_del).remove();
        });
        $('.customerTel').on('keypress', function (e) {
            if (e.charCode >= 48 && e.charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });
    });

    $('.customerTel').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }
    });
    // Customer End


    //Address Start
    $('#province').change(function () {
        var provinceID = $('#province').val();
        if (provinceID != "") {
            $.ajax({
                url: "../admin/fetchAmphur",
                method: "POST",
                data: {
                    provinceID: provinceID
                },
                dataType: "JSON",
                success: function (data) {
                    // console.log(data.amphur);
                    $('#amphur').html(data.amphur);
                    $('#district').html('<option value="" disable selected>กรุณาเลือกแขวง</option>');
                    $('#postcode').html('<option value="" disable selected>กรุณาเลือกรหัสไปรษณีย์</option>');
                }
            });
        }
    });

    $('#amphur').change(function () {
        var amphurID = $('#amphur').val();
        if (amphurID != '') {
            $.ajax({
                url: "../admin/fetchDistrict",
                method: "POST",
                data: {
                    amphurID: amphurID
                },
                dataType: "JSON",
                success: function (data) {
                    $('#district').html(data.district);
                    $('#postcode').html('<option value="" disable selected>กรุณาเลือกรหัสไปรษณีย์</option>');
                }
            });
        }
    });

    $('#district').change(function () {
        var districtID = $('#district').val();
        if (districtID != '') {
            $.ajax({
                url: "../admin/fetchPostcode",
                method: "POST",
                data: {
                    districtID: districtID
                },
                dataType: "JSON",
                success: function (data) {
                    $('#postcode').html(data.postcode);
                }
            });
        }
    });
    //Address End

    //general start
    $('.bgtable').mouseover(function () {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "#C6FFF8");
    });
    $('.bgtable').mouseout(function () {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "");
    });
    //general end
});


