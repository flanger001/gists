var Game = function(choice1, choice2){
  var rules = {
    "scissors": ["paper", "lizard"],
    "paper": ["rock", "spock"],
    "rock": ["scissors", "lizard"],
    "lizard": ["spock", "paper"],
    "spock": ["scissors", "rock"],
  };

  if (rules[choice1] !== undefined && rules[choice2] !== undefined) {
    if (choice1 !== choice2) {
      var winner = rules[choice1].indexOf(choice2) > -1 ? choice1 : choice2;
      return 'In the battle of ' + choice1 + ' vs. ' + choice2 + '... ' + winner.charAt(0).toUpperCase() + winner.substring(1) + ' wins!';
    } else {
      return 'We have a tie!';
    }
  } else {
    return 'Invalid choices!';
  }
};

var choices = ['rock', 'paper', 'scissors', 'lizard', 'spock'];

// Plays out all the games
choices.forEach(function(value, index, array){
  for (var i = 0, len = array.length; i < len; i++) {
    console.log(Game(value, array[i]));
  }
});