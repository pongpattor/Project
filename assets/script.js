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
                if (data.status == true) {
                    location.replace(data.url);
                }
                else {
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
    function validChangePassword() {
        var Errors = 0;
        var passwordNew = $('#passwordNew').val();
        var rePasswordNew = $('#rePasswordNew').val();
        var passwordOld = $('#passwordOld').val();
        if (passwordNew == rePasswordNew) {
            // $('#newPasswordError').html('');
            if (passwordNew != passwordOld) {
                $('#newPasswordError').html('');
            }
            else {
                Errors = 1;
                $('#newPasswordError').html('กรุณากรอกรหัสผ่านใหม่กับรหัสผ่านเก่าให้ไม่เหมือนกัน');
            }
        }
        else {
            Errors = 1;
            $('#newPasswordError').html('กรุณากรอกรหัสผ่านใหม่ให้เหมือนกัน');
        }
        return Errors;
    }

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการเปลี่ยนรหัสผ่านใหม่');
        if (cf == true) {
            var result = validChangePassword();
            if (result == 0) {
                $.ajax({
                    url: "../admin/rePassword",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        if (data.status == true) {
                            alert('แก้ไขรหัสผ่านเสร็จสิ้น');
                            location.replace(data.url);
                        }
                        else {
                            $('#passwordError').html('กรุณากรอกรหัสผ่านเก่าให้ถูกต้อง');
                            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        }
                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
            }
        }

    });

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


    //TypeProduct Start


    $('#addTypeProductForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../typeproduct/insertTypeProduct",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status == true) {
                    alert('เพิ่มข้อมูลประเภทสินค้าเสร็จสิ้น');
                    location.replace(data.url);
                } else {
                    if (data.typeProductNameError == '') {
                        $('#typeProductNameError').html('');
                    }
                    else {
                        $('#typeProductNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                    }
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                }
            }
        });
    });

    $('#editTypeProduct').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../typeproduct/updateTypeProduct",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('แก้ไขข้อมูลประเภทสินค้าเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        if (data.typeProductNameError == '') {
                            $('#typeProductNameError').html('');
                        }
                        else {
                            $('#typeProductNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                        }
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    }
                }
            });
        }

    });
    //TypeProduct End

    //Product Start

    $('#typeProductGroup').on('change', function () {
        var typeProductGroup = $(this).val();
        $.ajax({
            url: "../product/fetchTypeProduct",
            method: "POST",
            data: { typeProductGroup: typeProductGroup },
            dataType: "JSON",
            success: function (data) {
                // console.log(data.productTypeProduct);
                $('#productType').html(data.productType);
            }
        });
    });

    $('#addProduct').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../product/insertProduct",
            method: "POST",
            processData: false,
            contentType: false,
            data: new FormData(this),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert('เพิ่มข้อมูลสินค้าเสร็จสิ้น');
                    location.replace(data.url);
                } else {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    $('#productNameError').html(data.productNameError);
                }
            }
        });
    });

    $('#editProduct').on('submit', function (e) {
        // alert('hello');
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../product/updateProduct",
                method: "POST",
                processData: false,
                contentType: false,
                data: new FormData(this),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('แก้ไขข้อมูลสินค้าเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        $('#productNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                    }
                }
            });
        }
    });
    //Product End

    //Ingredient Start

    $('#addIngredientForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../ingredient/insertIngredient",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.status == true) {
                    alert('เพิ่มข้อมูลวัตถุดิบเสร็จสิ้น');
                    location.replace(data.url);
                } else {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    $('#ingredientNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                }
            }

        });
    });

    $('#editIngredientForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            $.ajax({
                url: "../ingredient/updateIngredient",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('แก้ไขข้อมูลวัตถุดิบเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        $('#ingredientNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                    }
                }
            });
        }
    });
    //Ingredient End


    //Recipet Start
    $('#recipeIngredientTable').DataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });

    $('#recipeProductTable').DataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });




    $('#recipeProductTable').on('click', '.selectProduct', function () {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        $('#recipeProduct').val(name);
        $('#recipeProductID').val(id);
        $('#recipeProductError').html('')

    });


    var rowIngredient = 1;
    $('.selectIngredient').on('click', function (e) {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        var txt = ` <tr id="rowi${rowIngredient}" class="d-flex">
                        <td style="text-align: center;" class="align-middle col-5 ">
                            <input type="text" name="recipeIngredient" value="${name}" class="form-control" disabled>
                            <input type="hidden" name="recipeIngredientID[]" class="recipeIngredientID" value="${id}">
                        </td>
                        <td style="text-align: center;" class="align-middle col-5">
                            <select name="ingredientImportant[]" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกความสำคัญวัตถุดิบ</option>
                                    <option value="1">สำคัญ</option>
                                    <option value="0">ไม่สำคัญ</option>
                            </select>
                        </td>
                        <td style="text-align: center;" class="align-middle col-2">
                            <button type="button" id="${rowIngredient}" class="btn btn-danger btn-remove"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>`;
        // console.log(txt);
        $('#bodyIngredient').append(txt);
        rowIngredient++;
        $('#ingredientError').html('');
        $('.btn-remove').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowi' + btn_del).remove();
        });
    });

    function validRecipe() {
        var Errors = 0;
        var recipeIngredientList = [];
        var breaker = 0;
        $('.recipeIngredientID').each(function () {
            var ingredient = $(this).val();
            recipeIngredientList.push(ingredient);
        });

        if (recipeIngredientList.length == 0) {
            Errors = 1;
            $('#ingredientError').html('กรุณาเลือกวัตถุดิบ');
        }
        else {
            for (var i = 0; i < recipeIngredientList.length; i++) {
                for (var j = 0; j < recipeIngredientList.length; j++) {

                    if (i == j) {
                        continue;
                    } else if (recipeIngredientList[i] == recipeIngredientList[j]) {
                        $('#ingredientError').html('กรุณาอย่าเลือกวัตถุดิบซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    break;
                } else {
                    $('#ingredientError').html('');
                }
            }
        }

        var rpID = $('#recipeProductID').val();
        if (rpID == '') {
            Errors = 1;
            $('#recipeProductError').html('กรุณาเลือกสินค้า')
        }
        else {
            $('#recipeProductError').html('')
        }
        return Errors;
    }

    $('#addRecipeForm').on('submit', function (e) {
        e.preventDefault();
        var result = validRecipe();
        if (result == 0) {
            $.ajax({
                url: "../recipe/insertRecipe",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('เพิ่มสูตรการผลิตเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        $('#recipeProductError').html('สินค้านี้มีสูตรการผลิตแล้ว');
                    }
                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
        }
    });

    $('#editRecipeForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validRecipe();
            if (result == 0) {
                $.ajax({
                    url: "../recipe/updateRecipe",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        if (data.status == true) {
                            alert('แก้ไขสูตรการผลิตเสร็จสิ้น');
                            location.replace(data.url);
                        } else {
                            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                            $('#recipeProductError').html('สินค้านี้มีสูตรการผลิตแล้ว');
                        }
                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
            }
        }

    });
    //Recipe END

    //LOT START
    $('#lotDrinkTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });

    $('#lotDrinkTable').on('click', '.selectLotDrink', function () {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        var idTr = $('#bodyLotDrink tr:last-child').attr('id');

        if (idTr == null) {
            var rowDrink = 1;
        }
        else {
            idTr = idTr.substr(4);
            var rowDrink = parseInt(idTr) + 1;
        }
        // alert(id+' '+' '+name);

        txt = `<tr id="rowd${rowDrink}" class="d-flex">
        <td style="text-align: center;" class="align-middle col-5 ">
            <input type="text" name="lotDrinkName" value="${name}" class="form-control" disabled>
            <input type="hidden" name="lotDrinkID[]" class="lotDrinkID" value="${id}">
        </td>
        <td style="text-align: center;" class="align-middle col-5">
            <input type="number" name="lotDrinkPrice[]" value="0" min="0" max="999999.99" step="0.01" class="form-control lotDrinkPrice"  required>
        </td>
        <td style="text-align: center;" class="align-middle col-2">
            <button type="button" id="${rowDrink}" class="btn btn-danger btn-removed"><i class="fa fa-minus"></i></button>
        </td>
    </tr>`;
        $('#bodyLotDrink').append(txt);
        $('#lotDrinkError').html('');
        var total = 0;
        $('.lotDrinkPrice').each(function () {
            total += parseFloat($(this).val());
        });
        $('#lotTotalShow').val(total);
        $('#lotTotal').val(total);

        $('.lotDrinkPrice').on('change', function () {
            total = 0;
            $('.lotDrinkPrice').each(function () {
                total += parseFloat($(this).val());
            });
            $('#lotTotalShow').val(total);
            $('#lotTotal').val(total);
        });

        $('.btn-removed').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowd' + btn_del).remove();

            total = 0;
            $('.lotDrinkPrice').each(function () {
                total += parseFloat($(this).val());
            });
            $('#lotTotalShow').val(total);
            $('#lotTotal').val(total);
        });
    });

    $('.lotDrinkPrice').on('change', function () {
        total = 0;
        $('.lotDrinkPrice').each(function () {
            total += parseFloat($(this).val());
        });
        $('#lotTotalShow').val(total);
        $('#lotTotal').val(total);
    });

    $('.btn-removed').on('click', function () {
        var btn_del = $(this).attr("id");
        $('#rowd' + btn_del).remove();
        total = 0;
        $('.lotDrinkPrice').each(function () {
            total += parseFloat($(this).val());
        });
        $('#lotTotalShow').val(total);
        $('#lotTotal').val(total);
    });
    function validLotDrink() {
        var Errors = 0;
        var lotDrinkList = [];
        var breaker = 0;
        $('.lotDrinkID').each(function () {
            var lotDrinkID = $(this).val();
            lotDrinkList.push(lotDrinkID);
        });

        if (lotDrinkList.length == 0) {
            Errors = 1;
            $('#lotDrinkError').html('กรุณาเลือกเครื่องดื่ม');
        }
        else {
            for (var i = 0; i < lotDrinkList.length; i++) {
                for (var j = 0; j < lotDrinkList.length; j++) {

                    if (i == j) {
                        continue;
                    } else if (lotDrinkList[i] == lotDrinkList[j]) {
                        $('#lotDrinkError').html('กรุณาอย่าเลือกเครื่องดื่มซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    break;
                } else {
                    $('#lotDrinkError').html('');
                }
            }
        }
        return Errors;
    }

    $('#addLotDrinkForm').on('submit', function (e) {
        e.preventDefault();
        var result = validLotDrink();
        if (result == 0) {
            $.ajax({
                url: "../lotdrink/insertLotDrink",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    alert('เพิ่มล็อตเครื่องดื่มเสร็จสิ้น');
                    location.replace(data.url);

                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
        }
    });

    $('#editLotDrinkForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validLotDrink();
            if (result == 0) {
                $.ajax({
                    url: "../lotdrink/updateLotDrink",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        alert('แก้ไขล็อตเครื่องดื่มเสร็จสิ้น');
                        location.replace(data.url);
                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            }
        }
    });

    $('#lotIngredientTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }

    });

    $('#lotIngredientTable').on('click', '.selectLotIngredient', function () {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        var idTr = $('#bodyLotIngredient tr:last-child').attr('id');
        if (idTr == null) {
            var rowIngredient = 1;
        }
        else {
            idTr = idTr.substr(4);
            var rowIngredient = parseInt(idTr) + 1;
        }
        // alert(rowIngredient);

        txt = `<tr id="rowi${rowIngredient}" class="d-flex">
        <td style="text-align: center;" class="align-middle col-5 ">
            <input type="text" name="lotIngredientName" value="${name}" class="form-control" disabled>
            <input type="hidden" name="lotIngredientID[]" class="lotIngredientID" value="${id}">
        </td>
        <td style="text-align: center;" class="align-middle col-5">
            <input type="number" name="lotIngredientPrice[]" value="0" min="0" max="999999.99" step="0.01" class="form-control lotIngredientPrice"  required>
        </td>
        <td style="text-align: center;" class="align-middle col-2">
            <button type="button" id="${rowIngredient}" class="btn btn-danger btn-removei"><i class="fa fa-minus"></i></button>
        </td>
    </tr>`;
        $('#bodyLotIngredient').append(txt);
        $('#lotIngredientError').html('');


        $('.lotIngredientPrice').on('change', function () {
            total = 0;
            $('.lotIngredientPrice').each(function () {
                total += parseFloat($(this).val());
            });
            $('#lotTotalShow').val(total);
            $('#lotTotal').val(total);
        });

        $('.btn-removei').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowi' + btn_del).remove();

            total = 0;
            $('.lotIngredientPrice').each(function () {
                total += parseFloat($(this).val());
            });
            $('#lotTotalShow').val(total);
            $('#lotTotal').val(total);
        });
    });

    $('.btn-removei').on('click', function () {
        var btn_del = $(this).attr("id");
        $('#rowi' + btn_del).remove();

        total = 0;
        $('.lotIngredientPrice').each(function () {
            total += parseFloat($(this).val());
        });
        $('#lotTotalShow').val(total);
        $('#lotTotal').val(total);
    });

    $('.lotIngredientPrice').on('change', function () {
        total = 0;
        $('.lotIngredientPrice').each(function () {
            total += parseFloat($(this).val());
        });
        $('#lotTotalShow').val(total);
        $('#lotTotal').val(total);
    });

    function validLotIngredient() {
        var Errors = 0;
        var lotIngredientList = [];
        var breaker = 0;
        $('.lotIngredientID').each(function () {
            var lotIngredientID = $(this).val();
            lotIngredientList.push(lotIngredientID);
        });

        if (lotIngredientList.length == 0) {
            Errors = 1;
            $('#lotIngredientError').html('กรุณาเลือกวัตถุดิบ');
        }
        else {
            for (var i = 0; i < lotIngredientList.length; i++) {
                for (var j = 0; j < lotIngredientList.length; j++) {

                    if (i == j) {
                        continue;
                    } else if (lotIngredientList[i] == lotIngredientList[j]) {
                        $('#lotIngredientError').html('กรุณาอย่าเลือกวัตถุดิบซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    break;
                } else {
                    $('#lotIngredientError').html('');
                }
            }
        }
        return Errors;
    }

    $('#addLotIngredientForm').on('submit', function (e) {
        e.preventDefault();
        var result = validLotIngredient();
        if (result == 0) {
            $.ajax({
                url: "../lotingredient/insertLotIngredient",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    alert('เพิ่มล็อตวัตถุดิบเสร็จสิ้น');
                    location.replace(data.url);

                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
        }
    });

    $('#editLotIngredientForm').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validLotIngredient();
            if (result == 0) {
                $.ajax({
                    url: "../lotingredient/updateLotIngredient",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        alert('แก้ไขล็อตวัตถุดิบเสร็จสิ้น');
                        location.replace(data.url);

                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            }
        }

    });

    //LOT END



    //PromotionSet Start
    $('#proSetProductTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });

    var rowProSet = 1;
    $('#proSetProductTable').on('click', '.selectProSetProduct', function () {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        // var cost = $('#' + rowid + ' td:nth-child(3)').html();
        // alert(id + ' ' + name + ' ' + cost + ' ' + price);
        txt = `<tr id="rowp${rowProSet}" class="d-flex">
        <td style="text-align: center;" class="align-middle col-5 ">
            <input type="text" name="proSetProductName" value="${name}" class="form-control" disabled>
            <input type="hidden" name="promotionSetProduct[]" class="promotionSetProduct" value="${id}">
        </td>
        <td style="text-align: center;" class="align-middle col-5">
            <input type="number" name="promotionSetAmount[]" value="1" min="1" max="99" class="form-control promotionSetAmount"  required>
        </td>
        <td style="text-align: center;" class="align-middle col-2">
            <button type="button" id="${rowProSet}" class="btn btn-danger btn-removep"><i class="fa fa-minus"></i></button>
        </td>
    </tr>`;

        $('#bodyProSetProduct').append(txt);
        rowProSet++;
        $('#proSetProductError').html('');



        $('.btn-removep').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowp' + btn_del).remove();
        });
    });

    function validPromotionSet() {
        var Errors = 0;
        var productList = [];
        var breaker = 0;
        $('.promotionSetProduct').each(function () {
            var productID = $(this).val();
            productList.push(productID);
        });

        if (productList.length == 0) {
            Errors = 1;
            $('#proSetProductError').html('กรุณาเลือกสินค้า');
        }
        else {
            for (var i = 0; i < productList.length; i++) {
                for (var j = 0; j < productList.length; j++) {

                    if (i == j) {
                        continue;
                    } else if (productList[i] == productList[j]) {
                        $('#proSetProductError').html('กรุณาอย่าเลือกสินค้าซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    break;
                } else {
                    $('#proSetProductError').html('');
                }
            }
        }

        return Errors;
    }

    $('#addPromotionSetForm').on('submit', function (e) {
        e.preventDefault();
        var result = validPromotionSet();
        if (result == 0) {
            $.ajax({
                url: "../promotionset/insertPromotionSet",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('เพิ่มโปรโมชั่นเซ็ตเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        $('#promotionSetNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                    }
                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            $('#promotionSetNameError').html('');
        }

    });

    // var rowProSet2 = 1;
    $('.editSelectProSetProduct').on('click', function () {
        var idTr = $('#bodyProSetProduct tr:last-child').attr('id');
        if (idTr == null) {
            rowProSet2 = '1';
        }
        else {
            idTr = idTr.substr(4);
            var rowProSet2 = parseInt(idTr) + 1;
        }
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        // alert(id + ' ' + name + ' ' + cost + ' ' + price);
        txt = `<tr id="rowp${rowProSet2}" class="d-flex">
        <td style="text-align: center;" class="align-middle col-5 ">
            <input type="text" name="proSetProductName" value="${name}" class="form-control" disabled>
            <input type="hidden" name="promotionSetProduct[]" class="promotionSetProduct" value="${id}">
        </td>
        <td style="text-align: center;" class="align-middle col-5">
            <input type="number" name="promotionSetAmount[]" value="1" min="1" max="99" class="form-control promotionSetAmount"  required>
        </td>
        <td style="text-align: center;" class="align-middle col-2">
            <button type="button" id="${rowProSet2}" class="btn btn-danger btn-removep"><i class="fa fa-minus"></i></button>
        </td>
        </tr>`;


        $('#bodyProSetProduct').append(txt);
        $('#proSetProductError').html('');

        $('.btn-removep').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowp' + btn_del).remove();
        });
    });
    $('.btn-removep').on('click', function () {
        var btn_del = $(this).attr("id");
        $('#rowp' + btn_del).remove();
    });


    $('#editPromotionSet').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validPromotionSet();
            if (result == 0) {
                $.ajax({
                    url: "../promotionset/updatePromotionSet",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        if (data.status == true) {
                            alert('เพิ่มโปรโมชั่นเซ็ตเสร็จสิ้น');
                            location.replace(data.url);
                        } else {
                            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                            $('#promotionSetNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                        }
                    }
                });
            }
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            $('#promotionSetNameError').html('');
        }
    });
    //PromotionSet End

    //PromotionPrice Start
    $('#proPriceProductTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }

    });


    $('#proPriceProductTable').on('click', '.selectProPriceProduct', function () {
        var rowid = $(this).parents("tr").attr("id");
        var id = $('#' + rowid + ' td').html();
        var name = $('#' + rowid + ' td:nth-child(2)').html();
        var idTr = $('#bodyProPriceProduct tr:last-child').attr('id');
        if (idTr == null) {
            var rowProprice = 1;
        }
        else {
            idTr = idTr.substr(5);
            var rowProprice = parseInt(idTr) + 1;
        }
        // alert(name);

        txt = `<tr id="rowpp${rowProprice}" class="d-flex">
            <td style="text-align: center;" class="align-middle col-8 ">
                <input type="text" name="promotionPriceProductName" value="${name}" class="form-control" disabled>
                <input type="hidden" name="promotionPriceProductID[]" class="promotionPriceProductID" value="${id}">
            </td>
            <td style="text-align: center;" class="align-middle col-4">
                <button type="button" id="${rowProprice}" class="btn btn-danger btn-removepp"><i class="fa fa-minus"></i></button>
            </td>
        </tr>`;
        $('#bodyProPriceProduct').append(txt);
        $('#ProPriceProductError').html('');
        $('.btn-removepp').on('click', function () {
            var btn_del = $(this).attr("id");
            $('#rowpp' + btn_del).remove();
        });
    });

    $('.btn-removepp').on('click', function () {
        var btn_del = $(this).attr("id");
        $('#rowpp' + btn_del).remove();
    });

    function validPromotionPrice() {
        var Errors = 0;
        var productList = [];
        var breaker = 0;
        $('.promotionPriceProductID').each(function () {
            var productID = $(this).val();
            productList.push(productID);
        });

        if (productList.length == 0) {
            Errors = 1;
            $('#ProPriceProductError').html('กรุณาเลือกสินค้า');
        }
        else {
            for (var i = 0; i < productList.length; i++) {
                for (var j = 0; j < productList.length; j++) {

                    if (i == j) {
                        continue;
                    } else if (productList[i] == productList[j]) {
                        $('#ProPriceProductError').html('กรุณาอย่าเลือกสินค้าซ้ำ');
                        Errors = 1;
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    break;
                } else {
                    $('#ProPriceProductError').html('');
                }
            }
        }

        return Errors;
    }

    $('#addPromotionPrice').on('submit', function (e) {
        e.preventDefault();
        var result = validPromotionPrice();
        if (result == 0) {
            $.ajax({
                url: "../promotionprice/insertPromotionPrice",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.status == true) {
                        alert('เพิ่มโปรโมชั่นลดราคาเสร็จสิ้น');
                        location.replace(data.url);
                    } else {
                        alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                        $('#promotionPriceNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                    }
                }
            });
        }
        else {
            alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            $('#promotionPriceNameError').html('');
        }
    });

    $('#editPromotionPrice').on('submit', function (e) {
        e.preventDefault();
        var cf = confirm('กรุณายืนยันการแก้ไข');
        if (cf == true) {
            var result = validPromotionPrice();
            if (result == 0) {
                $.ajax({
                    url: "../promotionprice/updatePromotionPrice",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        if (data.status == true) {
                            alert('เพิ่มโปรโมชั่นลดราคาเสร็จสิ้น');
                            location.replace(data.url);
                        } else {
                            alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                            $('#promotionPriceNameError').html('ชื่อนี้ได้ถูกใช้ไปแล้ว');
                        }
                    }
                });
            }
            else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
                $('#promotionPriceNameError').html('');
            }
        }


    });

    //PromotionPrice End

    //QUEUE START
    $('#queueTimeForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "../queue/updateQueueTime",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                alert('แก้ไขเวลาเลยกำหนดเสร็จสิ้น');
                location.reload();
            }
        });
    });


    $('#deskTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });

    $('#queueDate').on('change', function () {
        var queueDate = $(this).val();
        $.ajax({
            url: "../queue/queueDesk",
            method: "POST",
            data: {
                queueDate: queueDate,
            },
            dataType: "JSON",
            success: function (data) {
                var deskTable = "";
                var rowd = 1;
                deskTable += `
                <table id="deskTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>โซน</th>
                        <th>จำนวนคน</th>
                        <th>เลือก</th> 
                    </tr>
                </thead>
                <tbody id="deskBody">
                `;
                $.each(data, function () {
                    $.each(this, function (key, value) {
                        // console.log(value);
                        deskTable += `<tr id="rowd${rowd}">`;
                        deskTable += `<td>${value.SEAT_ID}</td>`;
                        deskTable += `<td>${value.SEAT_NAME}</td>`;
                        deskTable += `<td>${value.ZONE_NAME}</td>`;
                        deskTable += `<td>${value.SEAT_AMOUNT}</td>`;
                        deskTable += `<td><button type="button" class="selectDesk btn btn-primary">เลือก</button></td>`;
                        deskTable += `</tr>`;
                        rowd++;
                    });
                });
                deskTable += `</tbody></table>`;
                // console.log(deskTable);

                $('#deskTableModal').html(deskTable);
                $('#deskTable').dataTable({
                    "lengthMenu": [
                        [5, 10, 25, -1],
                        [5, 10, 25, "All"]
                    ], "columnDefs": [
                        { "className": "dt-center", "targets": "_all" }
                    ], "language": {
                        "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
                        "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
                    }
                });
                $('#deskTable').on('click', '.selectDesk', function () {
                    var id = $(this).parents('tr').attr('id');
                    var deskId = $(`#${id} td:nth-child(1)`).html();
                    alert(deskId);
                    
                });
            }
        });
    });


    //QUEUE END



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

    var pathhh = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === pathhh) {
            $(this).addClass("active");
        }
    });

    $(".sb-topnav .navbar-nav .nav-item a.nav-link").each(function () {
        if (this.href === pathhh) {
            $(this).addClass("active");
        }
    });

    $('.dateStart').on('change', function () {
        var dateStart = $(this).val();
        $('.dateEnd').val('');
        $('.dateEnd').attr('min', dateStart);
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


