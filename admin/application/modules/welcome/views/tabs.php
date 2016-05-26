<aside class="bg-white" >
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="active">
                        <a class="active" href="#projects" data-toggle="tab">
                        <?= lang('recent_projects') ?></a>
                        </li>
                        <li class=""><a href="#bugs" data-toggle="tab"><?= lang('recent_bugs') ?></a></li>
                        <li class=""><a href="#invoices" data-toggle="tab"><?= lang('upcoming_invoices') ?></a></li>
                      </ul>

                    <section class="scrollable">
                      <div class="tab-content">
                        <div class="tab-pane active" id="projects">
                          

                          <table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('timer') ?></th>
                                    <th class="col-md-3"><?= lang('project_name') ?> </th>
                                    <th class="col-md-3"><?= lang('client_name') ?> </th>
                                    <th class="col-md-3"><?= lang('progress') ?></th>
                                    <th class="col-options no-sort col-md-1"><?= lang('options') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$projects = Project::get_uncomplete(5);
if (count($projects) > 0) {
    foreach ($projects as $key => $project) {
        $progress = round(Project::get_progress($project->project_id),2);
        ?>
                                        <tr>
                        <?php $timer = ($project->timer == 'Off') ? 'success' : $timer = 'danger'; ?>

                                            <td>
                                            <span class="label label-<?=$timer?>"><?=$project->timer?></span>
                                            </td>

                                            <td>
                                            <a href="<?=base_url()?>projects/view/<?=$project->project_id?>">
                                            <?= $project->project_title ?>
                                            </a>
                                            </td>

                                            <td>
                                            <?php echo Client::view_by_id($project->client)->company_name; ?>
                                            </td>


                                            <td><?php $bg = ($progress >= 100) ? 'success' : 'danger'; ?>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-<?=$bg?>" data-toggle="tooltip" data-original-title="<?=$progress?>%" style="width: <?=$progress?>%"></div>
                                                </div>
                                            </td>



                                            <td>
                                                <a class="btn  btn-dark btn-xs" href="<?=base_url()?>projects/view/<?= $project->project_id?>">
                                                    <i class="fa fa-suitcase text"></i> <?=lang('project')?></a>
                                            </td>
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?=lang('nothing_to_display')?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>





                        </div>
                        <div class="tab-pane" id="bugs">


                          <table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('bug_status') ?></th>
                                    <th class="col-md-3"><?= lang('issue_title') ?> </th>
                                    <th class="col-md-3"><?= lang('priority') ?></th>
                                    <th class="col-options no-sort col-md-1"><?= lang('options') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$bugs = Project::get_bugs(5);
if (!empty($bugs)) {
    foreach ($bugs as $key => $bug) {
        ?>
                                        <tr>
                            <?php $status = ($bug->bug_status == 'Resolved') ? 'success' : 'danger'; ?>

                                            <td>
                                            <span class="label label-<?=$status?>">
                                            <?=$bug->bug_status;?>
                                            </span>
                                            </td>

                                            <td>
                                              <a href="<?=base_url()?>projects/view/<?=$bug->project?>?group=bugs&view=bug&id=<?=$bug->bug_id?>">
                                              <?= $bug->issue_title ?>
                                              </a>
                                            </td>

                                            <td>
                                            <span class="label label-success">
                                            <?=lang($bug->priority)?>
                                            </span>
                                            </td>

                                            <td>
                                                <a class="btn  btn-dark btn-xs" href="<?=base_url()?>projects/view/<?=$bug->project?>?group=bugs&view=bug&id=<?=$bug->bug_id?>">
                                               <?= lang('view_details') ?></a>
                                            </td>
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?= lang('nothing_to_display') ?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>


                        </div>
                        <div class="tab-pane" id="invoices">
                          
<table class="table table-striped m-b-none text-sm">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><?= lang('reference_no') ?></th>
                                    <th class="col-md-3"><?= lang('client_name') ?> </th>
                                    <th class="col-md-2"><?= lang('due_date') ?></th>
                                    <th class="col-md-2"><?= lang('due_amount') ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$invoices = Invoice::get_invoices(5);
foreach ($invoices as $key => &$invoice) {
    if(Invoice::payment_status($invoice->inv_id) == lang('fully_paid')){
            unset($invoices[$key]);
        }
        if(strtotime($invoice->due_date) < time()) unset($invoices[$key]);
}
$invoices = array_slice($invoices, 0, 5);

if (!empty($invoices)) {
    foreach ($invoices as $key => &$invoice) {
        ?>
                                        <tr>
                                            
                                            <td>
                                            <a href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>">
                                            <span class="label label-primary"><?=$invoice->reference_no;?></span>
                                            </a>
                                            </td>
                                           <td>
                                           <?php echo Client::view_by_id($invoice->client)->company_name;?>
                                           </td>
                                           <td><span class="label label-danger">
                                           <?=strftime(config_item('date_format'), strtotime($invoice->due_date))?>
                                           </span>
                                           </td>
                                            <td class="col-currency">
                                            <?php echo Applib::format_currency($invoice->currency, Invoice::get_invoice_due_amount($invoice->inv_id));
                                            ?></td>
                                            
                                        </tr>
    <?php }
} else { ?>
                                    <tr>
                                        <td colspan="4"><?= lang('nothing_to_display') ?></td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>





                        </div>
                      </div>
                    </section>
                </aside>