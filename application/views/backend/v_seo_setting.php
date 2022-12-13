<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    
                    <h4 class="card-title mt-2">Pengaturan SEO</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 grid-margin">
                        <?= form_open('', 'id="formSEO" class="form-sample"');?>
                          <div class="form-group">
                            <label for="meta_description">Meta Description *</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="4" maxlength="255" required><?= $this->seo->meta_description ?></textarea>
                            <small><em class="text-danger">(Maksimal 255 Karakter)</em></small>
                          </div>
                          <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Meta Keywords" value="<?= $this->seo->meta_keywords ?>">
                          </div>
                          <div class="form-group">
                            <label for="meta_author">Meta Author *</label>
                            <input type="text" class="form-control" id="meta_author" name="meta_author" placeholder="Meta Description" value="<?= $this->seo->meta_author ?>" required="required">
                          </div>
                          <div class="form-group">
                            <label for="meta_subject">Meta Subject</label>
                            <input type="text" class="form-control" id="meta_subject" name="meta_subject" placeholder="Email Instansi" value="<?= $this->seo->meta_subject ?>">
                          </div>
                          <div class="form-group">
                            <label for="schema_org">Schema org *</label>
                            <textarea class="form-control" id="schema_org" name="schema_org" rows="20" required><?= $this->seo->schema_org ?></textarea>
                            <small class="text-danger">Kunjungi website <a href="https://technicalseo.com/tools/schema-markup-generator/" title="Schema Markup Generator" target="_blank" rel="noopener noreferrer nofollow">berikut</a> untuk membuat schema org. </small>
                          </div>
                          <button type="submit" id="btnSave" class="btn btn-primary p-md-2 float-right"><i id="saveIcon" class="fas fa-save"></i><i id="loadingIcon" class="fa fa-spinner fa-spin fa-fw d-none"></i><span class="sr-only">Loading...</span> Simpan</button>
                          <button type="reset" class="btn btn-dark p-md-2 mr-2 float-right"><i class="fas fa-redo"></i>Reset</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>