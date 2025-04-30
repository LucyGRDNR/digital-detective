<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Play Story</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div id="chapter-content"></div>

<div id="question-container" style="display: none;">
    <div id="question-content"></div>

    <div id="options-container" style="display: none;"></div>

    <input type="text" id="answer-input" style="display: none;" placeholder="Zadejte odpověď...">
    <button id="submit-answer" style="display: none;">Odeslat</button>
</div>

<button id="next-button" style="display: none;">Další</button>

<script>
    let currentChapterId = {{ $first_chapter_id }};

    function loadChapter(id) {
    $.ajax({
        url: '/chapter/' + id,
        method: 'GET',
        success: function(data) {
            $('#answer-input').val(''); 
            $('#chapter-content').text(data.content);

            if (data.question) {
                $('#question-container').show();
                $('#question-content').text(data.question.question_text);

                if (data.question.question_type == 1) {
                    $('#options-container').show().html('');
                    data.question.options.forEach(function(option) {
                        $('#options-container').append(`
                            <button class="option-btn" data-id="${option.id}">${option.text}</button>
                        `);
                    });
                    $('#answer-input').hide();
                    $('#submit-answer').hide();
                } else {
                    $('#options-container').hide();
                    $('#answer-input').show();
                    $('#submit-answer').show();
                }
                $('#next-button').hide();

            } else {
                $('#question-container').hide();
                $('#options-container').hide();
                $('#answer-input').hide();
                $('#submit-answer').hide();

                if (data.next_chapter_id) {
                    $('#next-button').show().off('click').on('click', function() {
                        currentChapterId = data.next_chapter_id;
                        loadChapter(currentChapterId);
                    });
                } else {
                    $('#next-button').hide();
                    $('#chapter-content').append('<p>End of the story.</p>');
                }
            }
        }
    });
}


    $(document).ready(function() {
        loadChapter(currentChapterId);

        $(document).on('click', '.option-btn', function() {
            let answerId = $(this).data('id');
            submitAnswer(answerId);
        });

        $('#submit-answer').click(function() {
            let userAnswer = $('#answer-input').val();
            userAnswer = userAnswer.toLowerCase();
            submitAnswer(userAnswer);
        });

        function submitAnswer(answer) {
            $.ajax({
                url: '/submit-answer/' + currentChapterId,
                method: 'POST',
                data: {
                    answer: answer,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    currentChapterId = data.next_chapter_id;
                    loadChapter(currentChapterId);
                },
                error: function() {
                    alert('There was an error submitting your answer.');
                }
            });
        }
    });
</script>

</body>
</html>
