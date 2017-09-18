<?php
$pagetitle = 'Categories';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">

        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    Categories
                </h3>
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="row">
                <div class="span6">
                    <form action="<?php echo \App\Config::W_ROOT . "admin/addcategory" ?>" method="post"
                          class="category-form form-horizontal">
                        <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                        <?php if ((!empty($category))) { ?>
                            <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                        <?php } ?>
                        <?php $name = (!empty($category['name'])) ? $category['name'] : '' ?>
                        <div class="control-group">
                            <label class="control-label">Name</label>

                            <div class="controls">
                                <div class="input-icon left">
                                    <input type="text" name="name" placeholder="Name" class="m-wrap medium"
                                           value="<?php echo $name; ?>"/>
                                </div>
                            </div>
                        </div>
                        <?php $slug = (!empty($category['slug'])) ? $category['slug'] : '' ?>
                        <div class="control-group">
                            <label class="control-label">Slug</label>

                            <div class="controls">
                                <div class="input-icon left">
                                    <input type="text" name="slug" placeholder="Slug" class="m-wrap medium"
                                           value="<?php echo $slug; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Parent Categories</label>

                            <div class="controls">
                                <select class="medium m-wrap" name="parent_id" tabindex="1">
                                    <option value="0">None</option>
                                    <?php foreach ($parent_cat as $option) { ?>
                                        <option
                                            value="<?php echo $option['4'] ?>" <?php echo (!empty($category['parent_id']) && $category['parent_id'] == $option['4']) ? 'selected="selected"' : ''; ?>><?php echo $option['1'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php $description = (!empty($category['description'])) ? $category['description'] : '' ?>
                        <div class="control-group">
                            <label class="control-label">Description</label>

                            <div class="controls">
                                <textarea class="large m-wrap" name="description"
                                          rows="3"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-actions" style="margin-left: 15px;">
                            <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                        </div>
                    </form>
                </div>

                <div class="span6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <h4><i class="icon-user"></i>Categories</h4>

                            <div class="actions">
                                <button class="btn red" id="deleteTriger">Delete</button>
                                <div class="btn-group">
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="i"></i> Make admin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="category-grid" class="display table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width:8px;"><input type="checkbox" id="bulkDelete"/>
                                    </th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Slug</th>
                                </tr>
                                </thead>
                            </table>
                            <!--</div>-->
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->

    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>

<script>
    var categoryAjaxPaginateUrl = "<?php echo \App\Config::W_ROOT ?>admin/categories-ajax-paginate";
    var categoryBulkDeleteUrl = "<?php echo \App\Config::W_ROOT ?>admin/bulk-delete-categories";
</script>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/category.js"></script>
<script>
    $(document).ready(function () {
        Category.initList();
    });
</script>
</body>


