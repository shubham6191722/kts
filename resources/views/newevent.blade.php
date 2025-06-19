<!-- Copyright (c) Microsoft Corporation. Licensed under the MIT License. -->

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    </head>

    <body>
        <main role="main" class="container">
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                <p class="mb-3">{{ session('error') }}</p>
                @if(session('errorDetail'))
                    <pre class="alert-pre border bg-light p-2"><code>{{ session('errorDetail') }}</code></pre>
                @endif
                </div>
            @endif

            <h1>New Interview</h1>
            <form method="POST">
                @csrf
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" name="eventSubject" />
                </div>
                <div class="form-group">
                    <label>Attendees</label>
                    <input type="text" class="form-control" name="eventAttendees" />
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label>Start</label>
                            <input type="datetime-local" class="form-control" name="eventStart" id="eventStart" />
                        </div>
                        @error('eventStart')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <textarea type="text" class="form-control" name="eventBody" rows="3"></textarea>
                    @php
                        $token = App\Models\Token::get();
                    @endphp
                    @foreach($token as $u_value)
                        <input type="hidden" name="user_id[]" value="{!! $u_value->user_id !!}" />
                    @endforeach
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Create" />
                <a class="btn btn-secondary" href="{!! route('outlook.calendar') !!}">Cancel</a>
            </form>
        </main>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>
