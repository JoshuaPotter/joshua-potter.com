if (!process.env.token) {
	console.log('Error: Specify token in environment');
	process.exit(1);
}

var Botkit = require('./lib/Botkit.js');
var os = require('os');

var controller = Botkit.slackbot({
	debug: false,
});

var bot = controller.spawn({
	token: process.env.token
}).startRTM();

var jeopardy = {
	0: {
		answer: "No active questions at the moment"
	}
};
var countdown;
var attachments;
var sleep = false;

controller.hears(['quiet', 'sleep', 'off', 'disable'], ['direct_mention,mention'], function(bot, message) {
	bot.reply(message, "Trivia disabled for 10 minutes");
	sleep = true;
	setTimeout(function() {
		sleep = false;
		bot.reply(message, "I'm back");
	}, (60000 * 10));
});

controller.hears(['trivia', 'play', 'jeopardy', 'question', ''], ['direct_mention,mention'], function(bot, message) {
	if(sleep === false) {
		if(Math.floor(Math.random() * (100 - 1 + 1)) + 1 <= 1) {
			var snlResponses = ["Welcome back to Slack trivia. Once again, I'm going to recommend that our viewers do something else.", "Go back to your podium.", "I hate my job!", "Let's go with toast for 600.", "Are you Icelandic or retarded?", "Of Simon & Garfunkel, which one is not Garfunkel?"];
			bot.reply(message, snlResponses[Math.floor(Math.random() * snlResponses.length)]);
		} else {
			do {
				clearTimeout(countdown);
				var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
				var xhttp = new XMLHttpRequest();
				xhttp.onload = function() {
					if (xhttp.readyState === 4 && xhttp.status == 200) {
						jeopardy = JSON.parse(xhttp.responseText);
						attachments = {
							'text': "The category is *" + jeopardy[0].category.title + "*.",
							'attachments': [{
								'fallback': 'what is this i dont even',
								'title': 'Question #' + jeopardy[0].id,
								'text': jeopardy[0].question,
								'color': '#' + Math.floor(Math.random()*16777215).toString(16),
							}]
						};
						if(jeopardy[0].invalid_count == null) {
							bot.reply(message, attachments);
						}
					}
				};
				xhttp.open("GET", encodeURI("http://jservice.io/api/random?count=1"));
				xhttp.send();
			} while (jeopardy[0].invalid_count != null);
			countdown = setTimeout(function() {
				var correctAnswer = jeopardy[0].answer;
				correctAnswer = correctAnswer.replace(/<(?:.|\n)*?>/gm, '');
				correctAnswer = correctAnswer.replace(/\\/g, '');
				bot.reply(message, "Doodoodoo, correct answer was *" + correctAnswer + "*.");
				jeopardy = {
					0: {
						answer: "No active questions at the moment"
					}
				};
			}, 25000);
		}
	}
});

controller.hears(['give up'], ['ambient'], function(bot, message) {
	if(jeopardy[0].answer !== "No active questions at the moment") {
		var correctAnswer = jeopardy[0].answer;
		correctAnswer = correctAnswer.replace(/<(?:.|\n)*?>/gm, '');
		correctAnswer = correctAnswer.replace(/\\/g, '');
		bot.reply(message, "The correct answer was *" + correctAnswer + "*.");
		clearTimeout(countdown);
		jeopardy = {
			0: {
				answer: "No active questions at the moment"
			}
		};
	}
});
controller.hears(['what is (.*)', 'what is a (.*)', 'what is an (.*)', 'what are (.*)', 'who is (.*)', 'who are (.*)', 'where is (.*)', '(.*)'], ['ambient'], function(bot, message) {
	if(jeopardy[0].answer !== "No active questions at the moment") {
		var answer = message.match[1];
		answer = answer.replace(/['"]+/g, '');
		var correctAnswer = jeopardy[0].answer;
		correctAnswer = correctAnswer.replace(/"/g, '');
		correctAnswer = correctAnswer.replace(/<(?:.|\n)*?>/gm, '');
			correctAnswer = correctAnswer.replace(/\\/g, '');
		if (answer.toLowerCase() == correctAnswer.toLowerCase()) {
			bot.reply(message, "Correct, the answer was *" + correctAnswer + "*!");
			clearTimeout(countdown);
			jeopardy = {
				0: {
					answer: "No active questions at the moment"
				}
			};
		} 
	}
});