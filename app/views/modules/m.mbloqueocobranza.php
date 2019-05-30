<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
             <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos sin procesar (<font color="red" size="3.pxs"><?php echo count($documentos)?></font>) </h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos No procesados en 15 dias </p>
                        <center><a href="index.php?action=verDocSinProcesar&tipo=2" class="btn btn-default" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    