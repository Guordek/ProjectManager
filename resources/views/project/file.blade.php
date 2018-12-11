@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Add files</h1>

                {!! Form::open(['url' => route('project.addFile', $project->id), 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    <div class="input-group input-file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">Choose</button>
                        </span>
                        <input type="text" class="form-control" placeholder='Choose a file...'/>
                        <span class="input-group-btn">
       			            <button class="btn btn-warning btn-reset" type="button">Reset</button>
    		            </span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function bs_input_file() {
            $(".input-file").before(
                function () {
                    if (!$(this).prev().hasClass('input-ghost')) {
                        var element = $("<input type='file' class='input-ghost' id='files[]' name='files[]' multiple style='visibility:hidden; height:0'>");
                        element.attr("name", $(this).attr("name"));
                        element.change(function () {
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function () {
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function () {
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor", "pointer");
                        $(this).find('input').mousedown(function () {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }

        $(function () {
            bs_input_file();
        });
    </script>
@endsection