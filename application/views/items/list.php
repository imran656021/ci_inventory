<?php $this->load->view('header') ?>

<div class="tableData">
    <h1>Item Lists</h1>
    <div class="create-btn-div">
        <a href="javascript:void(0)" class="btn btn-success create-btn" id="createItem">Create</a>
    </div>
    <!-- =====================Modal Part start here ================= -->
    <!-- =====================Modal Part start here ================= -->

    <div id="itemModal" class="modal">

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
                <th>Item</th>
                <th>Model Name</th>
                <th>Brand Name</th>
                <th>Entry Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">

            <!-- <tr>
                <td>1</td>
                <td>Polo Shirt</td>
                <td>Model 101</td>
                <td>Brand</td>
                <td>Jan 10, 2022</td>
                <td>
                    <a href="" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr> -->

        </tbody>


    </table>
</div>
<script src="<?= base_url() . 'assets/js/jquery-3.6.0.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/modal.js' ?>"></script>
<script>
    $('#itemError').html('');
    $('#nameError').html('');

    //innitial setup end====================
    $('#modalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#itemModal').css('display', 'none');
    });
    $('#alertModalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#alertModal').css('display', 'none');
    });

    //===============================create Item modla show=============
    $('#createItem').click(function(e) {
        e.preventDefault();
        $('#formTitle').html('Add Items');
        $.ajax({
            url: '<?= base_url() . 'ItemController/allFormData' ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {

                var brands = response['brands'];
                var models = response['models'];
                //if the brands and modelss data retrive successfully then model show=======
                $('#itemModal').css('display', 'block');
                var brandData = '';
                for (var i = 0; i < brands.length; i++) {
                    brandData = brandData + `<option value='${brands[i]['id']}'>${brands[i]['name']}</option>`;

                }

                var modelOption = '';
                for (var j = 0; j < models.length; j++) {
                    if (models[j]['brand_id'] == brands[0]['id']) {
                        modelOption += `
                            <option value='${models[j]['id']}'>${models[j]['name']}</option>
                        `;
                    }
                }

                //+brandData+ goes as option of select Brand
                var createItemForm = `
                            <form action='' method='post' id='createItem' name='createItem'>
                                <label for='name'>Brand Name</label>
                                <select name='brand_id' id='brand_id' class='form-control'>
                                ` +
                    brandData +
                    `</select>
                                <br>
                                <label for='model_id'>Model Name</label>
                                <select name='model_id' id='model_id' class='form-control' placeholder='Select A Model'>
                                    ` + modelOption + `
                                </select>
                                <p id='brandIdError'></p>
                                <label for='modelName'>Model Name</label>
                                <input class='form-control' type='text' id='name' name='name' placeholder='Enter Model Name'>
                                <input type='hidden' id='id' name='id'>
                                <p id='nameError'></p>

                                <input class='btn btn-success' type='submit' id='submit' name='submit' value='Add Item'>
                            </form>
                `;
                $('#form').html(createItemForm);
            }
        })
    });

    //==========when clicked a brands names show the existing modle under this brands=================
    //model data existing Brand  ==modelDataEB
    function modelDataEB(id) {
        $.ajax({
            url: '<?= base_url() . 'ItemController/modelListExitBrandId/' ?>' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var modelOption = '';
                if (response) {
                    for (var i = 0; i < response.length; i++) {
                        modelOption += `
                        <option value='${response[i]['id']}'>${response[i]['name']}</option>
                    `;
                    }

                    $('#model_id').html(modelOption);
                }
            }
        });
    }
    $('body').on('change', '#brand_id', function(e) {
        e.preventDefault();
        var brandId = $('body #brand_id').val();
        modelDataEB(brandId);

    })

    $('body').on('submit', '#createItem', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url() . 'ItemController/store' ?>',
            type: 'post',
            dataType: 'json',
            data: $('body #createItem').serializeArray(),
            success: function(response) {
                // console.log(response);
                if (response['status'] == 1) {
                    $('#nameError').html('');
                    if (response['db_res'] == 'success') {
                        $('#itemModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Item Data Insert SuccessFully').css('color', 'green');
                        showItem();

                    } else {
                        $('#alertModal').css('display', 'block');
                        // $('#itemModal').css('display', 'none');
                        $('#successAlert').html('This item already Exit !!! Duplicate Data !!!').css('color', 'red');
                    }

                } else {
                    $('#nameError').html(response['name_error']).css('color', 'red');
                }
            }
        })
    })

    function showItem() {
        $.ajax({
            url: '<?= base_url() . 'ItemController/showItem' ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                var tr = '';
                var sl =0;

                for(var k=0; k<response.length; k++){
                     sl = k+1;
                    var name = response[k]['name'];
                    var id = response[k]['id'];
                    // console.log(name);
                    var model_name = response[k]['model_name'];
                    var brandname = response[k]['brandname'];
                    var entry_date  = response[k]['entry_date'];

                    tr += `<tr>
                            <td>${sl}</td>
                            <td>${name}</td>
                            <td>${model_name}</td>
                            <td>${brandname}</td>
                            <td>${entry_date}</td>
                            <td>
                                <a class='btn btn-success' onclick='editItem(${id})'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
                                <a class='btn btn-danger' onclick='deleteItem(${id})'><i class='fa fa-trash' aria-hidden='true'></i></a>
                            </td>
                        </tr>
                            `;
                }
                $('#tableBody').html(tr);
                // console.log(tr);

            }
        });
    }
    showItem();

    //delete Item from Item tablee============

    function deleteItem(id){


        if (confirm("Are you sure want to delete data Permanently ????")) {
            $.ajax({
                url: '<?= base_url().'ItemController/delete/'?>' + id,
                type: 'delete',
                dataType: 'json',
                success: function(response) {
                    if (response == 'success') {
                        $('#alertModal').css('display', 'block');
                        
                        $('#successAlert').html('Item Data Delete Successfully !!').css('color', 'red');
                        showItem();
                    }
                }

            });
        }

    }
//edite data retirve and open popup form with existing values
    function editItem(id){
        $('#formTitle').html('Edit Item');
        $.ajax({
            url: '<?= base_url().'ItemController/editFormData/'?>'+id,
            type: 'get',
            dataType: 'json',
            success: function(response) {

                var brands = response['brands'];
                var models = response['models'];
                var item = response['item'];
                //if the brands and modelss data retrive successfully then model show=======
                $('#itemModal').css('display', 'block');
                var brandData = '';
                for (var i = 0; i < brands.length; i++) {
                    var selectBrand = '';
                    if(brands[i]['id'] == item['brand_id']){
                        selectBrand = 'selected';
                        var selectedBrandId = brands[i]['id'];
                    }else{
                        selectBrand = '';
                    } 
                    brandData = brandData + `<option value='${brands[i]['id']}' ${selectBrand}>${brands[i]['name']}</option>`;

                }

                var modelOption = '';
                for (var j = 0; j < models.length; j++) {
                    var selectModel = '';
                    if (models[j]['id'] == item['model_id']) {
                        selectModel = 'selected';
                    }
                    if(models[j]['brand_id'] == item['brand_id']){
                        modelOption += `
                            <option value='${models[j]['id']}' ${selectModel}>${models[j]['name']}</option>
                        `;
                    }
                   
                }

                //+brandData+ goes as option of select Brand
                var createItemForm = `
                            <form action='' method='post' id='updateItem' name='updateItem'>
                                <label for='name'>Brand Name</label>
                                <select name='brand_id' id='brand_id' class='form-control'>
                                ` +
                    brandData +
                    `</select>
                                <br>
                                <label for='model_id'>Model Name</label>
                                <select name='model_id' id='model_id' class='form-control' placeholder='Select A Model'>
                                    ` + modelOption + `
                                </select>
                                <p id='brandIdError'></p>
                                <label for='modelName'>Model Name</label>
                                <input class='form-control' type='text' id='name' name='name' value='${item['name']}'>
                                <input type='hidden' id='id' name='id' value ='${item['id']}'>
                                <p id='nameError'></p>

                                <input class='btn btn-success' type='submit' id='submit' name='submit' value='Update Item'>
                            </form>
                `;
                $('#form').html(createItemForm);
            }
        })
    }

    //update function ==================

    $('body').on('submit', '#updateItem',function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url().'ItemController/updateItem'?>',
            type: 'post',
            dataType: 'json',
            data: $('#updateItem').serializeArray(),
            success: function(response){
                console.log(response);
                if(response['status'] == 1 && response['db_res'] == 'success'){
                    $('#itemModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Item Data Updated SuccessFully!!!').css('color', 'green');
                        showItem();
                }else if(response['status'] == 1 && response['db_res'] == 'duplicate'){
                    // $('#itemModal').css('display', 'none');
                        $('#alertModal').css('display', 'block');
                        $('#successAlert').html('Item Allready Exist!!!!! Duplicate Data!!!').css('color', 'red');
                }
            }

        });
    });


</script>
</body>

</html>