<div class="card" style="grid-column: span 1 / span 1;">
  <div class="card-body">
    <div class="card-header d-flex">
      <!-- Vertical Nav Tabs -->
      <ul class="nav nav-pills flex-column me-3" id="v-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="tab-label-history" data-bs-toggle="pill" href="#tab-content-history" role="tab"
            aria-controls="tab-content-history" aria-selected="true">Riwayat Aktivitas</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="tab-label-history2" data-bs-toggle="pill" href="#tab-content-history2" role="tab"
            aria-controls="tab-content-history2" aria-selected="false">Riwayat Aktivitas2</a>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content" id="tabs-bp-content">
        <div class="tab-pane fade show active" id="tab-content-history" role="tabpanel" aria-labelledby="tab-label-history">
          <div class="p-4">
            <div class="form-group row">
              <label class="col-12 mb-2 control-label text-bold-700">
                Post Title <span class="text-danger text-bold-700">*</span>
              </label>
              <div class="col-12 col-md-8 mb-2">
                <input type="text" class="form-control" name="title" id="title">
                <small class="form-text text-danger" id="title_error"></small>
              </div>
            </div>
            <hr>
            <textarea name="body" cols="30" rows="10" class="summer form-control"></textarea>
          </div>
        </div>

        <div class="tab-pane fade" id="tab-content-history2" role="tabpanel" aria-labelledby="tab-label-history2">
          <div class="p-4">
            <p>This is the second tab content.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
