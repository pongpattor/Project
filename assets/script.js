//All customer
$(document).ready(function () {

    //Login
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "./login/userLogin",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if(data.status == true){
                    location.replace(data.url);
                }
                else{
                    $('#password').val('');
                    alert('กรุณากรอก Username หรือ Password ให้ถูกต้อง');
                }
            }

        });

    });


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
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
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
        }

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

    //Employee Start

    $('#employeeDepartment').on('change', function () {
        var departmentID = $(this).val();
        $.ajax({
            url: "../admin/fetchPosition",
            method: "POST",
            data: { departmentID: departmentID },
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                $('#employeePosition').html(data.position);
            }
        });
    });

    var addEmployeeTel = 1;
    $('#addEmployeeTel').click(function () {
        addEmployeeTel++;
        var txt = `<tr id="row${addEmployeeTel}">
                        <td><input type="tel" class="form-control employeeTel" name="employeeTel[]" maxlength="10" minlength="10" required></td>
                        <td><button type="button" id="${addEmployeeTel}" class="btn btn-danger btn-remove float-right">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tr>`;
        $('#bodyTel').append(txt);

        $('.btn-remove').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#row' + btn_del).remove();
        });

        $('.employeeTel').on('keypress', function (e) {
            if (e.charCode >= 48 && e.charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });
    });

    function validationEmployee() {
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
                    $('#employeeTelError').html('กรุณาอย่ากรอกเบอร์ซ้ำ');
                    Errors = 1;
                    breaker = 1;
                    break;
                }
            }
            if (breaker == 1) {
                break;
            } else {
                $('#employeeTelError').html('');
            }
        }
        return Errors;
    }


    $('#addEmployeeForm').on('submit', function (e) {
        e.preventDefault();
        var result = validationEmployee();
        if (result == 0) {
            // var formData = new FormData($('#addEmployeeForm')[0]);

            $.ajax({
                url: "../employee/insertEmployee",
                method: "POST",
                processData: false,
                contentType: false,
                data: new FormData(this),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.employeeIdCardError == '') {
                            $('#employeeIdCardError').html('');
                        }
                        else {
                            $('#employeeIdCardError').html(data.employeeIdCardError);
                        }
                        alert(data.message);
                    }

                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
        }
    });

    $('#editEmployeeForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validationEmployee();
            if (result == 0) {
                $.ajax({
                    url: "../employee/updateEmployee",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: new FormData(this),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        if (data.status == true) {
                            alert('แก้ไขข้อมูลพนักงานเสร็จสิ้น');
                            location.replace(data.url);
                        } else {
                            if (data.employeeIdCardError == '') {
                                $('#employeeIdCardError').html('');
                            }
                            else {
                                $('#employeeIdCardError').html(data.employeeIdCardError);
                            }
                            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        }
                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            }
        }
    });


    //Employee End


    //Zone Start
    $('#addZoneForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../zone/insertZone",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    if (data.zoneNameError == '') {
                        $('#zoneNameError').html('');
                    }
                    else {
                        $('#zoneNameError').html(data.zoneNameError);
                    }
                    alert(data.message);
                }
            }
        });
    });

    $('#editZoneForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../zone/updateZone",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.zoneNameError == '') {
                            $('#zoneNameError').html('');
                        }
                        else {
                            $('#zoneNameError').html(data.zoneNameError);
                        }
                        alert(data.message);
                    }
                }
            });
        }
    });

    //Zone End

    //Desk Start
    $('#addDeskFrom').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../desk/insertDesk",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    if (data.deskNameError == '') {
                        $('#deskNameError').html('');
                    }
                    else {
                        $('#deskNameError').html(data.deskNameError);
                    }
                    alert(data.message);
                }
            }
        });
    });

    $('#editDeskForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../desk/updateDesk",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.deskNameError == '') {
                            $('#deskNameError').html('');
                        }
                        else {
                            $('#deskNameError').html(data.deskNameError);
                        }
                        alert(data.message);
                    }
                }
            });
        }
    });

    //Desk End

    //Karaoke Start
    $('#addKaraokeForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../karaoke/insertKaraoke",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert(data.message);
                    location.replace(data.url);
                } else {
                    if (data.karaokeNameError == '') {
                        $('#karaokeNameError').html('');
                    }
                    else {
                        $('#karaokeNameError').html(data.karaokeNameError);
                    }
                    alert(data.message);
                }
            }
        });
    });

    $('#editKaraokeForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../karaoke/updateKaraoke",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert(data.message);
                        location.replace(data.url);
                    } else {
                        if (data.karaokeNameError == '') {
                            $('#karaokeNameError').html('');
                        }
                        else {
                            $('#karaokeNameError').html(data.karaokeNameError);
                        }
                        alert(data.message);
                    }
                }
            });
        }

    });
    //Karaoke End




    //Address Start
    $('#province').change(function () {
        var provinceID = $('#province').val();
        // alert(provinceID);
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#Image").change(function () {
        var result = $(this).val();
        if (result != '') {
            var file = this.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#Image').val('');
                $('#imageError').html('กรุณาเลือกเฉพาะรูปภาพ');

            }
            else {
                readURL(this);
                $('#imageError').html('');
            }
        }
        else {
            $('#imageError').html('');
        }

    });

    $('#idCard').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }
    });

    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

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


