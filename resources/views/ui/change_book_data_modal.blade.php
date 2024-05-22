<div class="modal fade modal-xl" id="change_book_modal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Könyv szerkesztése</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <label for="title">Cím</label>
            <input type="text" name="title" id="title" value="{{ $book['book']->title }}" class="form-control">
            <div class="alert alert-danger mt-2" id="title_error" role="alert">
               
            </div>
          </div>
          <div class="col-6">
            <label for="publish">Megjelenés éve</label>
            <input type="number" name="publish" id="publish" value="{{ $book['book']->publish_date }}" class="form-control">
            <div class="alert alert-danger mt-2" id="publish_error" role="alert">
               
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-6">
            <label for="description">Ismertető</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ $book["book"]->description }}</textarea>
            <div class="alert alert-danger mt-2" id="description_error" role="alert">
               
            </div>
          </div>
          <div class="col-6">
            <label for="writers">Szerző(k)</label>
            <input type="text" name="writers" id="writers" value="{{ $book['book']->writers }}" class="form-control">
            <div class="alert alert-danger mt-2" id="writers_error" role="alert">
               
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-6">
            <label for="genre">Műfaj</label>
            <input type="text" name="genre" id="genre" value="{{ $book['book']->genre }}" class="form-control">
            <div class="alert alert-danger mt-2" id="genre_error" role="alert">
               
            </div>
          </div>
          <div class="col-6">
            <label for="publisher">Kiadó</label>
            <input type="text" name="publisher" id="publisher" value="{{ $book['book']->publisher }}" class="form-control">
            <div class="alert alert-danger mt-2" id="publisher_error" role="alert">
               
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-6">
            <label for="language">Nyelv</label>
            <input type="text" name="langugage" id="language" value="{{ $book['book']->language }}" class="form-control">
            <div class="alert alert-danger mt-2" id="language_error" role="alert">
               
            </div>
          </div>
          <div class="col-6">
            <label for="number_of_pages">Oldalak száma</label>
            <input type="number" name="number_of_pages" id="number_of_pages" value="{{ $book['book']->number_of_pages }}" class="form-control">
            <div class="alert alert-danger mt-2" id="number_of_pages_error" role="alert">
               
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
        <button type="button" class="btn btn-success" id="confirm_book_update" value="{{ $book['book']->isbn }}">Módosítás</button>
      </div>
    </div>
  </div>
</div>