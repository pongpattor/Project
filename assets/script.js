//All customer
$(document).ready(function () {

    //Login Start
    //ยังไม่ใช้ หรือ ไม่ได้ใช้
    // $("#username").keypress(function (event) {
    //     var ew = event.which;
    //     if (ew == 32)
    //         return true;
    //     if (48 <= ew && ew <= 57)
    //         return true;
    //     if (65 <= ew && ew <= 90)
    //         return true;
    //     if (97 <= ew && ew <= 122)
    //         return true;
    //     return false;
    // });

    // $("#password").keypress(function (event) {
    //     var ew = event.which;
    //     if (ew == 32)
    //         return true;
    //     if (48 <= ew && ew <= 57)
    //         return true;
    //     if (65 <= ew && ew <= 90)
    //         return true;
    //     if (97 <= ew && ew <= 122)
    //         return true;
    //     return false;
    // });


    //Login End


    //customerType

    $('#addCustomerTypeForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../customerType/insertCustomerType",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    alert(data.message);
                    $('#customerTypeNameError').html(data.message);
                }
            }
        });

    });

    $('#editCustomerTypeForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
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
        }
    });




    //customer
    function validationCustomer() {
        var Errors = 0;
        var telList = [];
        var breaker = 0;
        $('input[type="tel"]').each(function () {
            var telephon = $(this).val();
            telList.push(telephon);
        });
        for (var i = 0; i < telList.length; i++) {
            for (var j = 0; j < telList.length; j++) {

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
            if (breaker == 1) {
                break;
            } else {
                $('#customerTelError').html('');
            }
        }
        return Errors;
    }

    $('#customerIdCard').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }
    });

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
                            $('#customerTelError').html(data.errorTel);
                        }
                        else {
                            $('#customerTelError').html(data.errorTel);
                        }
                        if (data.errorIdCard == '') {
                            $('#customerIdCardError').html(data.errorIdCard);
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
                        <td><input type="tel" class="form-control customerTel" name="customerTel[]" maxlength="10" minlength="10" required></td>
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

    $('#editCustomerForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validationCustomer();
            if (result == 0) {
                $.ajax({
                    url: "../customer/updateCustomer",
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
                                $('#customerTelError').html(data.errorTel);
                            }
                            else {
                                $('#customerTelError').html(data.errorTel);
                            }
                            if (data.errorIdCard == '') {
                                $('#customerIdCardError').html(data.errorIdCard);
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
        }

    });


    // Customer End


    //Department Start

    $('#addDepartmentForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../department/insertDepartment",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    $('#departmentNameError').html(data.departmentNameError);
                    alert(data.message);
                }
            }
        });
    });

    $('#editDepartmentForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../department/updateDepartment",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    $('#departmentNameError').html(data.departmentNameError);
                    alert(data.message);
                }
            }
        });
    });
    //Department End

    //Position Start


    $('.chkper').click(function () {
        var perList = [];
        $('input[type=checkbox]').each(function () {
            if ($(this).prop("checked") == true) {
                perList.push(1)
            } else {
                perList.push(0)
            }
        });
        $('#positionPermission').val(perList);
        // console.log(perList);
    });

    $('#addPositionForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../position/insertPosition",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    $('#positionNameError').html(data.positionNameError);
                    alert(data.message);
                }
            }
        });
    });

    $('#editPositionForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../position/updatePosition",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.positionNameError == '') {
                            $('#positionNameError').html('');
                        }
                        else {
                            $('#positionNameError').html(data.positionNameError);

                        }
                        alert(data.message);
                    }
                }
            });
        }
    });


    //Position End


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


