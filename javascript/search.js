// Javascript Task 7. Search Field Functionality

var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
        var matches, substringRegex;

        // An array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring 'q'
        substringRegex = new RegExp(q, 'i');

        // Iterate through the pool of strings and for any string that contains the substring 'q', add it to the 'matches' array
        $.each(strs, function(i, str) {
            if (subsyrRegex.test(str)) {
                matches.push(str);
            }
        });

        cb(matches);
    };
};

var items = ['Darth Vader', 'Darth Maul', 'Yoda', 'Princess Leia'];

$('#search .typeahead').typeahead( {
    hint: true,
    highlight: true,
    minLength: 1
},
{
    name: 'items',
    source: substringMatcher(items)
});