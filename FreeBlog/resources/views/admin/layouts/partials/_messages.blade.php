            @if (count($errors) > 0)
                <div class="card-panel red darken-3">
                    <ul class="white-text">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('session_msg') )
                <div id="session_msg" class="card-panel teal">
                <span  class="white-text">{{ session('session_msg') }}</span>
                </div>
            @endif