
<div class="page-content-wrapper">

    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Shipping Agent Detail
                    </div>

                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->

                    <div class="form-body">                               
                        <h4 class="form-section detail-form-heading">Shipping Agent Info</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Name:</label>
                                    <div class="col-md-8">

                                        <?php echo $shipping['name'];
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Area Code:</label>
                                    <div class="col-md-8">

                                        <?php
                                        echo $shipping['code'];
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <!--/span-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Telephone:</label>
                                    <div class="col-md-8">

                                        <?php
                                        if (isset($shipping['telephone']) && !empty($shipping['telephone']))
                                            echo $shipping['telephone'];
                                        else
                                            echo "Nill";
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Coverage Area</label>
                                    <div class="col-md-8">

                                        <?php
                                        if (isset($shipping['coverage_area']) && !empty($shipping['coverage_area']))
                                            echo $shipping['coverage_area'];
                                        else
                                            echo "Nill";
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <div class="row">

                            <!--/span-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Contact Person:</label>
                                    <div class="col-md-8">
                                       
                                        <?php echo $shipping['contact_person'] ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">City:</label>
                                    <div class="col-md-8">

                                        <?php
                                        if (isset($shipping['city']) && !empty($shipping['city']))
                                            echo $shipping['city'];
                                        else
                                            echo "Nill";
                                        ?>

                                    </div>
                                </div>
                           
                            <!--/span-->
                                            
                        </div>
                        </div>
                        <!--/row-->

                        <!--/row-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Fax:</label>
                                    <div class="col-md-8">

                                        <?php
                                        if (isset($shipping['fax']) && !empty($shipping['fax']))
                                            echo $shipping['fax'];
                                        else
                                            echo "Nill";
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Email:</label>
                                    <div class="col-md-8">

                                        <?php
                                        if (isset($shipping['email']) && !empty($shipping['email']))
                                            echo $shipping['email'];
                                        else
                                            echo "Nill";
                                        ?>

                                    </div>
                                </div>
                            </div>         

                        </div>
                        
                            
                    </div>
				  </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
    <!--    </div>-->
</div>
</div>
