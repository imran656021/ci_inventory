<?php $this->load->view('header') ?>

<div class="tableData">
    <h1>Model Lists</h1>
    <div class="create-btn-div">
        <a href="javascript:void(0)" class="btn btn-success create-btn" id="createModel">Create</a>
    </div>
    <!-- =====================Modal Part start here ================= -->
    <!-- =====================Modal Part start here ================= -->

    <div id="brandModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="brandForm">
            <div class="modal-header">
                <span class="close" id="modalCloseBtn">&times;</span>
                <h2 id="formTitle">Add Model</h2>
            </div>
            <div class="modal-body">
                <div class="brand-form" id="form">
                    <!-- form html load from js  -->
                </div>

            </div>

        </div>
    </div>
    <!-- ============alert Modal============ -->



    <div id="alertModal" class="modal">
        <div class="modal-content" id="alertModalContent">
            <div class="modal-header">
                <span class="close" id="alertModalCloseBtn">&times;</span>
            </div>
            <div class="modal-body">

                <h4 id="successAlert"></h4>
            </div>

        </div>
    </div>

    <!-- =====================Modal Part end here ================= -->
    <!-- =====================Modal Part end here ================= -->
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Model Name</th>
                <th>Brand name</th>
                <th>Entry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="modelTable">
            <!-- //load tabel row from js -->
        </tbody>



    </table>
</div>
<script src="<?= base_url() . 'assets/js/jquery-3.6.0.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/modal.js' ?>"></script>
<script>
    //initial setup ======================
    $('#brandIdError').html('');
    $('#nameError').html('');

    //innitial setup end====================
    $('#modalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#brandModal').css('display', 'none');
    });
    $('#alertModalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#alertModal').css('display', 'none');
    });
    //=========================show create model popup Modal===============
    $('#createModel').click(function(e) {
        e.preventDefault();
        $('#formTitle').html('Add Model');
        $.ajax({
            url: '<?= base_url() . 'BrandController/allData' ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var data = response['allData'];
                // console.log(data.length);
                $('#brandModal').css('display', 'block');
                var brandData = '';
                for (var i = 0; i < data.length; i++) {
                    brandData = brandData + `<option value='${data[i]['id']}'>${data[i]['name']}</option>`;

                }
                //+brandData+ goes as option of select Brand
                var createModelForm = `
                            <form action='' method='post' id='createModel' name='createModel'>
                                <label for='name'>Brand Name</label>
                                <select name='brand_id' id='brand_id' class='form-control'>` +
                    brandData +
                    `</select>
                                <p id='brandIdError'></p>
                                <label for='modelName'>Model Name</label>
                                <input class='form-control' type='text' id='name' name='name' placeholder='Enter Model Name'>
                                <input type='hidden' id='id' name='id'>
                                <p id='nameError'></p>

                                <input class='btn btn-success' type='submit' id='submit' name='submit' value='Add Model'>
                            </form>
                `;
                $('#form').html(createModelForm);
            }
        })

    });

    $('body').on('submit', '#createModel', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url() . 'ModelController/store' ?>',
            type: 'post',
            dataType: 'json',
            data: $('body #createModel').serializeArray(),
            success: function(response) {
                if (response['status'] == 0) {
                    if (response['brandIdError'] != '') {
                        $('#brandIdError').html(response['brandIdError']).css('color', 'red');
                    }
                    if (response['nameError'] != '') {
                        $('#nameError').html(response['nameError']).css('color', 'red');
                    }
                } else {
                    //when finaly data inserted===============
                    $('#brandIdError').html('');
                    $('#nameError').html('');
                    if (response['db_res'] == 'success') {

                        $('#brandModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Modal Data Insert Successfully !!!!!').css('color', 'green');
                        viewModels();
                    }else if(response['db_res'] == 'error'){
                        // $('#brandModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Something Went Wrorng !!!').css('color', 'red');
                        viewModels();
                    }else{
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Data Already Exit in table !!!').css('color', 'red');
                        viewModels();
                    }
                }

            }
        });
    })

    function viewModels() {
        $.ajax({
            url: '<?= base_url() . 'Modelcontroller/allData' ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var brand = response['brand'];
                var models = response['models'];
                var tr = '';
                var sl = 1;
                //start foro loop===================
                for (var i = 0; i < models.length; i++) {
                    for (var j = 0; j < brand.length; j++) {
                        if (brand[j]['id'] == models[i]['brand_id']) {
                            var brandName = brand[j]['name'];
                        }
                    }
                    tr += `
                    <tr id='${models[i]['id']}'>
                <td>${sl+i}</td>
                <td>${models[i]['name']}</td>
                <td>
                     ` + brandName + `   
                </td>
                <td>${models[i]['entry_date']}</td>
                <td>
                <a onclick='editModel(${models[i]['id']})' class='btn btn-success'>
                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                </a>
				<a onclick='deleteModel(${models[i]['id']})' class='btn btn-danger'>
                    <i class='fa fa-trash' aria-hidden='true'></i>
                </a>
                </td>
            </tr>
                    `;
                }
                //end foro loop===================
                // console.log(tr);
                $('#modelTable').html(tr);
            }
        });
    }

    // ==============================Show all Data in table====================
    viewModels();
    // ==============================Show all Data in table====================


    // ==============================Delete Model Data ====================

    function deleteModel(id) {
        if (confirm("Are you sure want to delete data Permanently ????")) {
            $.ajax({
                url: '<?= base_url() . 'ModelController/delete/' ?>' + id,
                type: 'delete',
                dataType: 'json',
                success: function(response) {
                    if (response == 'success') {
                        $('#brandModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        
                        $('#successAlert').html('Model Data Delete Successfully !!').css('color', 'red');
                        viewModels();
                    }
                }

            });
        }

    }

    // ==============================edite Model Data Popup edite form ====================

    function editModel(id) {
        $('#formTitle').html('Update Model');

        $.ajax({
            url: '<?= base_url() . 'ModelController/editModel/' ?>'+id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                // var data = response['models'];
                var brand = response['brand'];
                var models = response['models'];
                
                // console.log(data.length);
                $('#brandModal').css('display', 'block');
                var brandData = '';
                var selectedOption = '';
                for (var i = 0; i < brand.length; i++) {
                    if(brand[i]['id'] == models['brand_id']){
                        selectedOption = 'selected';
                    }else{
                        selectedOption = '';
                    }
                    brandData = brandData + `<option value='${brand[i]['id']}' ${selectedOption}>${brand[i]['name']}</option>`;

                }
                //+brandData+ goes as option of select Brand
                var createModelForm = `
                            <form action='' method='post' id='updateModel' name='updateModel'>
                                <label for='name'>Brand Name</label>
                                <select name='brand_id' id='brand_id' class='form-control'>` +
                    brandData +
                    `</select>
                                <p id='brandIdError'></p>
                                <label for='modelName'>Model Name</label>
                                <input class='form-control' type='text' id='name' name='name' placeholder='Enter Model Name' value='${models['name']}'>
                                <input type='hidden' id='id' name='id' value='${models['id']}'>
                                <p id='nameError'></p>

                                <input class='btn btn-success' type='submit' id='submit' name='submit' value='Update Model'>
                            </form>
                `;
                $('#form').html(createModelForm);
            }
        })
    }

    //===============================Model Data Update ======================
    $('body').on('submit', '#updateModel',function(e){
        e.preventDefault();
        // console.log('hello update modal');
        $.ajax({
            url: '<?=base_url().'ModelController/updateModel'?>',
            type: 'post',
            dataType: 'json',
            data: $('#updateModel').serializeArray(),
            success: function(response){
                console.log(response);
                if(response['status'] == 1){
                    $('body #nameError').html('');
                    if(response['db_res'] == 'duplicate'){
                        $('#alertModal').css('display', 'block');
                        // $('#brandModal').css('display', 'none');
                        $('#successAlert').html('Model Already Exist in Same Brands').css('color', 'red');
                        viewModels();
                    }else if(response['db_res'] == 'success'){
                        $('#alertModal').css('display', 'block');
                        $('#brandModal').css('display', 'none');
                        $('#successAlert').html('Model Data Update Successfully').css('color', 'green');
                        viewModels();
                    }else{
                        $('#alertModal').css('display', 'block');
                        $('#brandModal').css('display', 'none');
                        $('#successAlert').html('Something went Wrong').css('color', 'red');
                        viewModels();
                    }
                }else{
                   
                    
                        if(response['nameError'] != ''){
                            $('body #nameError').html(response['nameError']);
                        }
                }
            }

        });
    });
</script>
</body>

</html>