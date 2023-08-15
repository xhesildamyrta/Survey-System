<div class="text-center font-medium text-2xl">{{__('This is a questionaire to test your personality')}}</div>
<body x-data="formData()">

    <div>
        <form>
            <template x-for="(question, qIndex) in questions" :key="qIndex">
                <div class="question-container">
                    <label x-text="'Question ' + (qIndex + 1) + ':'"></label>
                    <input type="text" x-model="question.text" required>
                    <button type="button" @click="removeQuestion(qIndex)">Remove</button>

                    <div class="answer">
                        <label>Answer 1:</label>
                        <input type="text" required>
                    </div>
                    <div class="answer">
                        <label>Answer 2:</label>
                        <input type="text" required>
                    </div>
                    <div class="answer">
                        <label>Answer 3:</label>
                        <input type="text" required>
                    </div>
                    <div class="answer">
                        <label>Answer 4:</label>
                        <input type="text" required>
                    </div>
                </div>
            </template>
            <button type="button" @click="addQuestion">Add Question</button>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        function formData() {
            return {
                questions: [{ text: '' }],
                addQuestion() {
                    this.questions.push({ text: '' });
                },
                removeQuestion(index) {
                    this.questions.splice(index, 1);
                },
            };
        }
    </script>

    </body>
