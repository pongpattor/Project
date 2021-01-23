<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขสมาชิก</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form method="POST" id="editCustomerForm">
                        <?php foreach ($customer as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>บัตรประจำตัวประชาชน </label>
                                    <input type="hidden" name="customerID" value="<?= $row->CUSTOMER_ID; ?>">
                                    <input type="hidden" name="customerIdCardOld" value="<?= $row->CUSTOMER_IDCARD; ?>">
                                    <input type="text" name="customerIdCard" id="idCard" class="form-control" maxlength="13" minlength="13" required value="<?= $row->CUSTOMER_IDCARD; ?>">
                                    <span id="customerIdCardError" style="color: red; "> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อ </label>
                                    <input type="text" name="customerFirstName" id="customerFirstName" class="form-control" maxlength="20" required value="<?= $row->CUSTOMER_FIRSTNAME; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>นามสกุล </label>
                                    <input type="text" name="customerLastName" id="customerLastName" class="form-control " maxlength="20" required value="<?= $row->CUSTOMER_LASTNAME; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เพศ </label>
                                    <select id="customerGender" name="customerGender" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกเพศ</option>
                                        <option value="M" <?php if ($row->CUSTOMER_GENDER == 'M') {
                                                                echo 'selected';
                                                            } ?>>ชาย</option>
                                        <option value="F" <?php if ($row->CUSTOMER_GENDER == 'F') {
                                                                echo 'selected';
                                                            } ?>>หญิง</option>
                                    </select>
                                    <span id="customerGenderError" style="color: red;"> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>วันเกิด</label>
                                    <input type="date" name="customerBdate" id="customerBdate" class="form-control " max="<?= date('Y-m-d'); ?>" value="<?= $row->CUSTOMER_BDATE; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <table style="width:100%" id="tablePhone">
                                        <tbody id="bodyTel">
                                            <tr>
                                                <td>เบอร์โทร</td>
                                            </tr>
                                            <?php
                                            $rowid = 1;
                                            foreach ($customerTel as $rowTel) { ?>
                                                <tr id="row<?= $rowid; ?>">
                                                    <input type="hidden" name="customerTelOld[]" value="<?= $rowTel->CUSTOMERTEL_TEL; ?>">
                                                    <td><input type="tel" class="form-control customerTel" name="customerTel[]" value="<?= $rowTel->CUSTOMERTEL_TEL; ?>" maxlength="10" minlength="10" required></td>
                                                    <td>
                                                        <?php if ($rowid == 1) { ?>
                                                            <button type="button" id="addTel" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                                        <?php } else { ?>
                                                            <button type="button" id="<?= $rowid; ?>" class="btn btn-danger btn-remove float-right"><i class="fa fa-minus"></i></button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $rowid++;
                                            } ?>
                                        </tbody>
                                    </table>
                                    <span id="customerTelError" style="color: red;"> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ที่อยู่</label>
                                    <textarea name="customerAddress" id="customerAddress" class="form-control" rows="5" maxlength="100" required><?= $row->CUSTOMER_ADDRESS ?></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>จังหวัด</label>
                                    <select id="province" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือกจังหวัด</option>
                                        <?php foreach ($province as $rowProvince) : ?>
                                            <option value="<?= $rowProvince->PROVINCE_ID; ?>" <?php
                                                                                                if ($rowProvince->PROVINCE_ID == $row->PROVINCE_ID) {
                                                                                                    echo 'selected';
                                                                                                }
                                                                                                ?>><?= $rowProvince->PROVINCE_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เขต</label>
                                    <select id="amphur" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกเขต</option>
                                        <?php foreach ($amphur as $rowAmphur) : ?>
                                            <option value="<?= $rowAmphur->AMPHUR_ID; ?>" <?php
                                                                                            if ($rowAmphur->AMPHUR_ID == $row->AMPHUR_ID) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                            ?>><?= $rowAmphur->AMPHUR_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>แขวง</label>
                                    <select id="district" name="district" class="form-control" required> 
                                        <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                        <?php foreach ($district as $rowDistrict) : ?>
                                            <option value="<?= $rowDistrict->DISTRICT_ID; ?>" <?php
                                                                                                if ($rowDistrict->DISTRICT_ID == $row->DISTRICT_ID) {
                                                                                                    echo 'selected';
                                                                                                }
                                                                                                ?>><?= $rowDistrict->DISTRICT_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>รหัสไปรษณีย์</label>
                                    <select id="postcode" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                        <?php foreach ($postcode as $rowPostcode) : ?>
                                            <option value="<?= $rowPostcode->POSTCODE; ?>" <?php
                                                                                            if ($rowPostcode->POSTCODE == $row->POSTCODE) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                            ?>><?= $rowPostcode->POSTCODE; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ประเภทสมาชิก</label>
                                    <select id="customerType" name="customerType" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                        <?php foreach ($customerType as $rowCustomerType) : ?>
                                            <option value="<?= $rowCustomerType->CUSTOMERTYPE_ID ?>" <?php
                                                                                                        if ($rowCustomerType->CUSTOMERTYPE_ID == $row->CUSTOMER_CUSTOMERTYPE) {
                                                                                                            echo 'selected';
                                                                                                        }
                                                                                                        ?>><?= $rowCustomerType->CUSTOMERTYPE_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/customer/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="แก้ไข">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var idTrTel = $('tbody tr:last-child').attr('id');
        idTrTel = idTrTel.substr(3);
        var addphone_id = parseInt(idTrTel);
        $('#addTel').on('click', function() {
            addphone_id++;
            var txt = `<tr id="row${addphone_id}">
                        <td><input type="tel" class="form-control customerTel" name="customerTel[]" maxlength="10" minlength="10" required></td>
                        <td><button type="button" id="${addphone_id}" class="btn btn-danger btn-remove float-right">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tr>`;
            $('#bodyTel').append(txt);

            $('.btn-remove').on('click', function() {
                var btn_del = $(this).attr("id");
                $('#row' + btn_del).remove();
            });
            $('.customerTel').on('keypress', function(e) {
                if (e.charCode >= 48 && e.charCode <= 57) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    });
</script>