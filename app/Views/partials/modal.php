<div class="modal" id="modal">
    <div class="modal-content">
        <div class="modal-container-1">
            <img class="modal-school-logo" src="/assets/LIU-Logo.svg" alt="School logo">
            <div class="modal-school-name-container">
                <p class="semi-bold modal-school-name-abv">LoremIU</p>
                <p class="semi-bold modal-school-name">LoremIpsum University</p>
            </div>
        </div>
        <h2>Exam Agreement & Instructions</h2>
        <div class="modal-container-2">
            <p>
                ⚠️ This examination is the intellectual property of
                LoremIpsum University. <span class="bold">You agree not to copy, share,
                    or record any part of this assessment.</span>
            </p>
            <p>
                🕒 The exam has a strict time limit of <span class="bold" id="modal-duration">60 minutes.</span>
                The timer starts once you click <span class="bold">"Start Exam"</span>.
                Closing or refreshing your browser may auto-submit
                or forfeit the test.
            </p>
            <p>
                💡 Make sure your internet connection is <span class="bold">stable</span>. All
                answers are auto-saved periodically.
            </p>
        </div>
        <div class="modal-container-3">
            <button class="modal-button" id="closeModalBtn">Cancel</button>
            <form method="get" action="/exam/take_exam">
                <button class="modal-button" id="modal-submit-button" type="submit" name="exam_id">Start Exam</button>
            </form>
        </div>
    </div>
</div>