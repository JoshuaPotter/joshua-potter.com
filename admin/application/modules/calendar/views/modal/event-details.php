<div class="modal-dialog">
    <div class="modal-content">
        
        
            <?php if (isset($task)) : ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=$task->task_name?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('projects/view/'.$task->project)?>"><?=$task->project_title?></a>
                    </span>
                    <?=lang('project')?>
                </li>
                <?php if ($task->milestone > 0) : ?>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php 
                        $milestones = $this->db->where('id',$task->milestone)->get('milestones')->result(); 
                        $milestone = $milestones[0];  ?>
                        <a href="<?=base_url('projects/view/'.$task->project.'/?group=milestones&view=milestone&id='.$task->milestone)?>"><?=$milestone->milestone_name?></a>
                    </span>
                    <?=lang('milestone')?>
                </li>
                <?php endif; ?>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo User::displayName($task->added_by); ?>
                    </span>
                    <?=lang('user')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php foreach (Project::task_team($task->t_id) as $u) : ?>
                        <?php $names[] = User::displayName($u->assigned_user); ?>
                        <?php endforeach; ?>
                        <?=isset($names) ? implode(", ", $names) : ''?>
                    </span>
                    <?=lang('assigned_to')?>
                </li>
            </ul>
            <p><?=$task->task_description?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
            <a href="<?=base_url('projects/view/' . $task->project . '?group=tasks&view=task&id=' . $task->t_id)?>" class="btn btn-primary text-white"><?=lang('view_task')?></a>
        </div>
            <?php endif; ?>
        
        
            <?php if (isset($payment)) : ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=lang('payment')?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('companies/view/'.$payment->paid_by)?>"><?=$payment->company_name?></a>
                    </span>
                    <?=lang('client')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('invoices/view/'.$payment->inv_id)?>"><?=$payment->reference_no?></a>
                    </span>
                    <?=lang('invoice')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right"><?=$payment->method_name?></span><?=lang('payment_method')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right"><?=Applib::format_currency($payment->currency, $payment->amount)?></span><?=lang('amount')?>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
            <a href="<?= base_url('payments/view/'.$payment->p_id) ?>" class="btn btn-primary text-white"><?=lang('view_payment')?></a>
        </div>
            <?php endif; ?>
        
            <?php if (isset($project)) : ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=$project->project_title?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('companies/view/'.$project->client)?>"><?=$project->company_name?></a>
                    </span>
                    <?=lang('client')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?=Project::get_progress($project->project_id);?>%
                    </span>
                    <?=lang('progress')?>
                </li>
            </ul>
            <p><?=$project->description?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
            <a href="<?= base_url('projects/view/' . $project->project_id) ?>" class="btn btn-primary text-white"><?=lang('view_project')?></a>
        </div>
            <?php endif; ?>
        
            <?php if (isset($invoice)) : ?>
                <?php $this->load->model('Invoice'); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=lang('invoice')?> <?=$invoice->reference_no?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('companies/view/'.$invoice->client)?>"><?=$invoice->company_name?></a>
                    </span>
                    <?=lang('client')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?=lang(Invoice::payment_status($invoice->inv_id)); ?>
                    </span>
                    <?=lang('payment_status')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?=Applib::format_currency($invoice->currency, Invoice::get_invoice_due_amount($invoice->inv_id))?>
                    </span>
                    <?=lang('balance_due')?>
                </li>
            </ul>
            <p><?=$invoice->notes?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
            <a href="<?= base_url('invoices/view/' . $invoice->inv_id) ?>" class="btn btn-primary text-white"><?=lang('view_invoice')?></a>
        </div>
            <?php endif; ?>
        
            <?php if (isset($estimate)) : ?>
                <?php $this->load->model('Estimate'); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=lang('estimate')?> <?=$estimate->reference_no?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <a href="<?=base_url('companies/view/'.$estimate->client)?>"><?=$estimate->company_name?></a>
                    </span>
                    <?=lang('client')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?=lang(strtolower($estimate->status))?>
                    </span>
                    <?=lang('estimate_status')?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?=Applib::format_currency($estimate->currency, Estimate::due($estimate->est_id))?>
                    </span>
                    <?=lang('estimate_cost')?>
                </li>
            </ul>
            <p><?=$estimate->notes?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
            <a href="<?= base_url('estimates/view/' . $estimate->est_id) ?>" class="btn btn-primary text-white"><?=lang('view_estimate')?></a>
        </div>
            <?php endif; ?>
        
        
</div>
</div>