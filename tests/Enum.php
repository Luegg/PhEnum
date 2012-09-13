<?php

require "../vendor/noonat/pecs/lib/pecs.php";
require "../Enum.php";

Luegg\PhEnum\define("Gender", array("Male", "Female"));
Luegg\PhEnum\define("Lyrics\\Word", array("Never", "Gonna", "Give", "You", "Up"));

describe("A enum factory", function(){
	it("declares a class", function(){
		expect(class_exists("Gender"))->to_be_true();
	});

	it("adds a static method for each type to the class", function(){
		expect(method_exists("Gender", "Male"))->to_be_true();
		expect(method_exists("Gender", "Female"))->to_be_true();
	});

	it("declares a function which converts ordinals to enums", function(){
		expect(function_exists("Gender"))->to_be_true();
		expect(Gender(1))->to_be(Gender::Female());
	});

	it("declares a class in a namespace", function(){
		expect(class_exists("Lyrics\\Word"))->to_be_true();
		expect(Lyrics\Word::Give())->not_to_be(Lyrics\Word::You());
		expect(Lyrics\Word(4))->to_be("Up");
	});
});

describe("An enum", function(){
	it("is comparable", function(){
		expect(Gender::Male())->to_be(Gender::Male());
		expect(Gender::Female())->to_be(Gender::Female());
		expect(Gender::Male())->not_to_be(Gender::Female());
	});

	it("returns an instance of Enum", function(){
		expect(Gender::Male())->to_be_an_instance_of("Luegg\PhEnum\Enum");
	});

	it("has a string representation", function(){
		expect((string)Gender::Male())->to_be("Male");
		expect(Gender::Female()->name())->to_be("Female");
	});

	it("has an ordinal which represents its position in the declaration", function(){
		expect(Gender::Male()->ordinal())->to_be(0);
		expect(Gender::Female()->ordinal())->to_be(1);
	});
});

\pecs\run(new \pecs\HtmlFormatter());