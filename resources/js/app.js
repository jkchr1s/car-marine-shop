'use strict';

import {VanillaLib as lib} from 'jkchr1s-libs';

// jQuery legacy code
$(function () {
    $.material.init();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// legacy code
window.goBack = () => {
    window.history.back();
}

lib.documentReady(() => {
    // handler for showing modals
    lib.forEachNode('[data-open-modal]', el => {
        const action = el.getAttribute('data-action') || null,
            method = el.getAttribute('data-method') || null,
            enableDelete = el.getAttribute('data-delete') || null,
            context = el.getAttribute('data-context') ? JSON.parse(el.getAttribute('data-context')) : null

        // bind click handler for the button
        el.addEventListener('click', e => {
            e.preventDefault();

            window.console && window.console.debug && window.console.debug('clicked', el);

            // if an action is defined, we need to over-write it at time of use
            if (action || method || context || enableDelete) {
                lib.forEachNode(`#${el.getAttribute('data-open-modal')} form`, form => {
                    if (action) {
                        // override the form action
                        form.setAttribute('action', action);
                    }
                    if (method) {
                        // override the form method
                        form.setAttribute('method', method);
                    }
                    if (context) {
                        // set values
                        Object.keys(context).forEach(key => {
                            lib.forEachNode(form.querySelectorAll(`[name="${key}"]`), input => {
                                $(input).val(context[key]);
                            })
                        });
                    }
                    if (enableDelete) {
                        // set the form method for delete functionality
                        lib.forEachNode(form.querySelectorAll('[data-delete]'), btn => {
                            btn.setAttribute('data-delete', enableDelete);
                        });
                    }
                });
            }
            $(`#${el.getAttribute('data-open-modal')}`).modal('toggle');
        });

        // for each associated form, override the default action on form submit
        lib.forEachNode(`#${el.getAttribute('data-open-modal')} form`, form => {
            // handle form submit
            form.addEventListener('submit', e => {
                e.preventDefault();
                // todo: use window.fetch instead
                $.ajax({
                    url: form.getAttribute('action'),
                    type: form.getAttribute('method'),
                    data: $(form).serialize(),
                    success: function() {
                        location.reload();
                    },
                    error: function(err) {
                        alert(JSON.stringify(err));
                    }
                });
            });

            // handle delete button in modal
            lib.forEachNode(form.querySelectorAll('[data-delete]'), deleteButton => {
                deleteButton.addEventListener('click', e => {
                    e.preventDefault();
                    // todo: use window.fetch instead
                    $.ajax({
                        url: deleteButton.getAttribute('data-delete'),
                        type: 'DELETE',
                        success: function() {
                            location.reload();
                        },
                        error: function(err) {
                            alert(JSON.stringify(err));
                        }
                    });
                });
            });
        });
    });
});
