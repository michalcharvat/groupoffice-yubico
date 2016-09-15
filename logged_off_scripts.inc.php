<script type='text/javascript'>
    Ext.override(GO.dialog.LoginDialog, {
        initComponent: GO.dialog.LoginDialog.prototype.initComponent.createSequence(function () {
            this.yubicoOTPField = new Ext.form.TextField({
                anchor: '100%',
                fieldLabel: GO.yubico.lang['yubicoOTP'],
                name: 'yubico_hash',
                inputType: 'password'
            });

            this.formPanel.insert(4, this.yubicoOTPField);
        })
    });
</script>