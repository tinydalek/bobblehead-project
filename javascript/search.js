// Javascript Task 7. Search Field Functionality

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};

var items = ['Darth Vader', 'Yoda', 'Princess Leia', 'Biker Scout', 'C3PO',
  'Chewbacca', 'Darth Maul', 'TIE Fighter', 'Finn', 'Jabba the Hutt', 'Luke Skywalker',
  'Obi Wan Kenobi', 'R2D2', 'Rey', 'Unmasked Vader', 'Luke Skywalker (X-Wing Pilot)'
];

$('#find .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'items',
  source: substringMatcher(items)
});