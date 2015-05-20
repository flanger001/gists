a = $('#onions');
a.data(); // Object {grossSmells: "that would be onions", onions: "many onions"}
a.data('onions'); // "many onions"
a.data().onions; // "many onions"

a.data('gross-smells'); // "that would be onions"
a.data('grossSmells'); // "that would be onions"
a.data().gross-smells; // Uncaught ReferenceError: smells is not defined
a.data().grossSmells; // "that would be onions"