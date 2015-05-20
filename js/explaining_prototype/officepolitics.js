// Now with 100% less jQuery!
// Now with 100% more correct syntax!

function OfficeDrone(fullname, age, position) {
  this.fullname = fullname;
  this.age = age;
  this.position = position;
}

function OldUselessAdministrator() {
  this.bothering_secretary = true;
}

function YoungSexySecretary() {
  this.run_away = function(speed){
    switch (speed) {
      case "fast":
        alert("Bye!");
        break;

      case "slow":
        alert("Oh, gee, sorry, I'm sooooo busy right now. Gotta go.");
        break;
    }
  };
}

OldUselessAdministrator.prototype = new OfficeDrone();
YoungSexySecretary.prototype = new OfficeDrone();

var Peggy = new OldUselessAdministrator("Peggy", "Infinity", "Who Cares");
var Maria = new YoungSexySecretary("Maria", "28", "Everything to everyone");

if (Peggy.bothering_secretary) {
  (Maria).run_away("fast");
}
