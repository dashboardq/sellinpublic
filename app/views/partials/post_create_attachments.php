                        <div class="attachments">
                            <?php if(isset($fields['attachment_count'])): ?>
                            <?php for($i = 0; $i < $fields['attachment_count']; $i++): ?>
                                <?php if($fields['attachment_type_' . $i] == 'text'): ?>
                                    <div class="attachment attachment_type_text">
                                        <?php $res->html->hidden('attachment_type_' . $i); ?>
                                        <p><button class="remove_attachment">Remove</button></p>
                                        <?php $res->html->textareaRaw('Add additional content...', 'attachment_text_' . $i); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <button class="add_text">Add Additional Text</button>
                        </div>

