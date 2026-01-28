<? if ($messages) : ?>
    <script>
        var diff = {};
    </script>
    <div class="row">
        <!--<label class="col-sm-2 col-form-label" for="">Observatii precedente:</label>-->
        <div class="col-sm-11 offset-sm-1">
            <ul class="timeline timeline-simple">
                <? foreach($messages AS $message) : $metadata = $message['metadata']; ?>
                    <script>
                        diff[<?= $message['id'] ?>] = {};
                    </script>
                    <li class="timeline-inverted">
                        <div class="timeline-badge <?= $messageIcons[$message['type']]['color'] ?>">
                            <i class="material-icons">
                                <?= $messageIcons[$message['type']]['icon'] ?>
                            </i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-body">
                                <p>
                                    <?= MESSAGE_TYPES[$message['type']] ?><?= $metadata['message'] ? ':' : '' ?>
                                    <?= $metadata['message'] ?: '' ?>
                                </p>
                                <? if ($metadata['fields']) : ?>
                                    <p>
                                        <? foreach ($metadata['fields'] as $i => $field) : ?>
                                            <? if ($field['title']) : ?>
                                                <?= $field['title'] ?><?= isset($field['value']) ? ':' : '' ?>
                                            <? endif; ?>
                                            <? if ($field['value']) : ?>
                                                <? if (!is_array($field['value'])) : ?>
                                                    <? if (!$field['is_html']) : ?>
                                                        <?= $field['value'] ?>
                                                    <? else : ?>
                                                        <script>
                                                            diff[<?= $message['id'] ?>]['<?= $i ?>'] = {
                                                                old: `<?= nl2br(str_replace('`', '"', $field['value_old']))  ?>`,
                                                                new: `<?= nl2br(str_replace('`', '"', $field['value'])) ?>`
                                                            };
                                                        </script>
                                                        <span class="table clear d-inline-block">
                                                            <span id="diff_<?= $message['id'] . '_' . $i ?>"
                                                                  class="d-inline-block row-404 row-404-250">
                                                                <?= $field['value'] ?>
                                                            </span>
                                                        </span>
                                                    <? endif; ?>
                                                <? else : ?>
                                                    <ul>
                                                        <? foreach ($field['value'] as $val) : ?>
                                                            <li><?= $val ?></li>
                                                        <? endforeach; ?>
                                                    </ul>
                                                <? endif; ?>
                                            <? endif; ?>
                                            <br />
                                        <? endforeach; ?>
                                    </p>
                                <? endif; ?>
                            </div>
                            <h6>
                                <?= date('d.m.Y H:i', $message['date']) ?>  / <?= $message['user'] ?>
                            </h6>
                        </div>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>

    <? captureJavaScriptStart(); ?>
    <style type="text/css">
        ins {
            text-decoration: none;
            background-color: #d4fcbc;
        }

        del {
            text-decoration: line-through;
            background-color: #fbb6c2;
            color: #555;
        }
    </style>
    <!--<script src="/public/site/js/vendor/htmldiff/htmldiff.min.js"></script>-->
    <script>
        $(document).ready(function() {
            if (window.Worker) {
                let htmlDiffWorker = new Worker('/public/admin/js/workers/htmldiff.js');

                htmlDiffWorker.postMessage(diff);
                htmlDiffWorker.onmessage = function(e) {
                    diff = e.data;

                    for (id in diff) {
                        for (key in diff[id]) {
                            $('#diff_' + id + '_' + key).html(diff[id][key]['diff']);
                        }
                    }

                    htmlDiffWorker.terminate();
                }
            }

            /*for (id in diff) {
                for (key in diff[id]) {
                    $('#diff_' + id + '_' + key).html(htmldiff(diff[id][key]['old'], diff[id][key]['new']));
                }
            }*/
        });
    </script>
    <? captureJavaScriptEnd(); ?>
<? endif; ?>