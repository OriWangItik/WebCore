<?php
namespace WebCore\Inputs;


use PHPUnit\Framework\TestCase;
use Traitor\TEnum;


class FromArrayTest extends TestCase
{
	public function test_withLength_InvalidParams_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->withLength(5, 2);
	}
	
	public function test_withLength_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 'a', 'b' => 'abc']);
		
		$subject->withLength(2, 5);
		
		self::assertNull($subject->string('a'));
		self::assertNotNull($subject->string('b'));
	}
	
	public function test_withExactLength_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->withExactLength(-8);
	}
	
	public function test_withExactLength_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 'a', 'b' => 'abc']);
		
		$subject->withExactLength(3);
		
		self::assertNull($subject->string('a'));
		self::assertNotNull($subject->string('b'));
	}
	
	public function test_between_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->between(5, 2);
	}
	
	public function test_between_InvalidParamA_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->between('test4', 2);
	}
	
	public function test_between_InvalidParamB_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->between(5, 'test5');
	}
	
	public function test_between_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 8, 'b' => 25]);
		
		$subject->between(10, 30);
		
		self::assertNull($subject->int('a'));
		self::assertNotNull($subject->int('b'));
	}
	
	public function test_greaterThen_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->greaterThen('fd8');
	}
	
	public function test_greaterThen_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 8, 'b' => 25]);
		
		$subject->greaterThen(10);
		
		self::assertNull($subject->int('a'));
		self::assertNotNull($subject->int('b'));
	}
	
	public function test_lessThen_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->lessThen('fd8');
	}
	
	public function test_lessThen_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 25, 'b' => 8]);
		
		$subject->lessThen(10);
		
		self::assertNull($subject->int('a'));
		self::assertNotNull($subject->int('b'));
	}
	
	public function test_greaterOrEqualThen_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->greaterOrEqualThen('fd8');
	}
	
	public function test_greaterOrEqualThen_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 8, 'b' => 25]);
		
		$subject->greaterOrEqualThen(25);
		
		self::assertNull($subject->int('a'));
		self::assertNotNull($subject->int('b'));
	}
	
	public function test_lessOrEqualThen_InvalidParam_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\ServerErrorException::class);
		
		$subject = new FromArray([]);
		$subject->lessOrEqualThen('fd8');
	}
	
	public function test_lessOrEqualThen_AppliedOnlyOnce()
	{
		$subject = new FromArray(['a' => 25, 'b' => 8]);
		
		$subject->lessOrEqualThen(10);
		
		self::assertNull($subject->int('a'));
		self::assertNotNull($subject->int('b'));
	}
	
	public function test_has_ItemExists_ReturnTrue()
	{
		$subject = new FromArray(['a' => 1]);
		
		self::assertTrue($subject->has('a'));
	}
	
	public function test_has_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->has('a'));
	}
	
	public function test_isInt_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isInt('a'));
	}
	
	public function test_isInt_ItemIsInt_ReturnTrue()
	{
		$subject = new FromArray(['a' => '1']);
		
		self::assertTrue($subject->isInt('a'));
	}
	
	public function test_isInt_ItemIsNotInt_ReturnFalse()
	{
		$subject = new FromArray(['a' => '1.1']);
		
		self::assertFalse($subject->isInt('a'));
	}
	
	public function test_isFloat_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isFloat('a'));
	}
	
	public function test_isFloat_ItemIsFloat_ReturnTrue()
	{
		$subject = new FromArray(['a' => '1.0']);
		
		self::assertTrue($subject->isFloat('a'));
	}
	
	public function test_isFloat_ItemIsNotFloat_ReturnFalse()
	{
		$subject = new FromArray(['a' => '1a']);
		
		self::assertFalse($subject->isFloat('a'));
	}
	
	public function test_isEmpty_NotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isEmpty('a'));
	}
	
	public function test_isEmpty_Empty_ReturnTrue()
	{
		$subject = new FromArray(['a' => '']);
		
		self::assertTrue($subject->isEmpty('a'));
	}
	
	public function test_isEmpty_NotEmpty_ReturnFalse()
	{
		$subject = new FromArray(['a' => '0']);
		
		self::assertFalse($subject->isEmpty('a'));
	}
	
	public function test_int_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals(1, $subject->int('a', 1));
	}
	
	public function test_int_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 2]);
		
		self::assertEquals(2, $subject->int('a', 1));
	}
	
	public function test_int_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->int('a'));
	}
	
	public function test_int_WithBetween()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->between(2, 8)->int('a'));
		self::assertNull($subject->between(10, 10)->int('a'));
		self::assertNull($subject->between(0, 2)->int('a'));
		self::assertNull($subject->between(-8, 7.8)->int('a'));
	}
	
	public function test_int_WithGreaterThen()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->greaterThen(5)->int('a'));
		self::assertNull($subject->greaterThen(8)->int('a'));
		self::assertNull($subject->greaterThen(10)->int('a'));
	}
	
	public function test_int_WithLessThen()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->lessThen(10)->int('a'));
		self::assertNull($subject->lessThen(2)->int('a'));
		self::assertNull($subject->lessThen(8)->int('a'));
	}
	
	public function test_int_WithGreaterOrEqualThen()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->greaterOrEqualThen(2)->int('a'));
		self::assertEquals(8, $subject->greaterOrEqualThen(8)->int('a'));
		self::assertNull($subject->greaterOrEqualThen(10)->int('a'));
	}
	
	public function test_int_WithLessOrEqualThen()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->lessOrEqualThen(10)->int('a'));
		self::assertEquals(8, $subject->lessOrEqualThen(8)->int('a'));
		self::assertNull($subject->lessOrEqualThen(2)->int('a'));
	}
	
	public function test_bool_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertTrue($subject->bool('a', true));
	}
	
	public function test_bool_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 't']);
		
		self::assertTrue($subject->bool('a', false));
	}
	
	public function test_bool_ExistsNotValid_ReturnDefault()
	{
		$subject = new FromArray(['a' => ['t']]);
		
		self::assertFalse($subject->bool('a', false));
	}
	
	public function test_bool_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->bool('a'));
	}
	
	public function test_float_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals(1.1, $subject->float('a', 1.1));
	}
	
	public function test_float_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => '3.2']);
		
		self::assertEquals(3.2, $subject->float('a', 1.1));
	}
	
	public function test_float_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->float('a'));
	}
	
	public function test_float_WithBetween()
	{
		$subject = new FromArray(['a' => 8.3]);
		
		self::assertEquals(8.3, $subject->between(2, 8.3)->float('a'));
		self::assertEquals(8.3, $subject->between(2, 9.3)->float('a'));
		self::assertNull($subject->between(10, 10)->float('a'));
		self::assertNull($subject->between(0.5, 2)->float('a'));
		self::assertNull($subject->between(-8, 7.8)->float('a'));
	}
	
	public function test_float_WithGreaterThen()
	{
		$subject = new FromArray(['a' => 8.3]);
		
		self::assertEquals(8.3, $subject->greaterThen(5.4)->float('a'));
		self::assertNull($subject->greaterThen(8.3)->float('a'));
		self::assertNull($subject->greaterThen(10)->float('a'));
	}
	
	public function test_float_WithLessThen()
	{
		$subject = new FromArray(['a' => 8.3]);
		
		self::assertEquals(8.3, $subject->lessThen(10.11)->float('a'));
		self::assertNull($subject->lessThen(2)->float('a'));
		self::assertNull($subject->lessThen(8.3)->float('a'));
	}
	
	public function test_float_WithGreaterOrEqualThen()
	{
		$subject = new FromArray(['a' => 8.3]);
		
		self::assertEquals(8.3, $subject->greaterOrEqualThen(2.55)->float('a'));
		self::assertEquals(8.3, $subject->greaterOrEqualThen(8.3)->float('a'));
		self::assertNull($subject->greaterOrEqualThen(10.4)->float('a'));
	}
	
	public function test_float_WithLessOrEqualThen()
	{
		$subject = new FromArray(['a' => 8.3]);
		
		self::assertEquals(8.3, $subject->lessOrEqualThen(10)->float('a'));
		self::assertEquals(8.3, $subject->lessOrEqualThen(8.3)->float('a'));
		self::assertNull($subject->lessOrEqualThen(2.47)->float('a'));
	}
	
	public function test_string_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->string('a', 'a'));
	}
	
	public function test_string_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->string('a', 'a'));
	}
	
	public function test_string_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->string('a'));
	}
	
	public function test_string_WithWithLength()
	{
		$subject = new FromArray(['a' => 'test']);
		
		self::assertNull($subject->withLength(0)->string('a'));
		self::assertEquals('test', $subject->withLength(4)->string('a'));
		self::assertEquals('test', $subject->withLength(2, 5)->string('a'));
		self::assertNull($subject->withLength(20, 25)->string('a'));
	}
	
	public function test_string_WithWithExactLength()
	{
		$subject = new FromArray(['a' => 'test']);
		
		self::assertNull($subject->withExactLength(0)->string('a'));
		self::assertNull($subject->withExactLength(15)->string('a'));
		self::assertEquals('test', $subject->withExactLength(4)->string('a'));
	}
	
	public function test_string_WithLength_Multibyte()
	{
		$subject = new FromArray(['a' => '-']);
		
		self::assertNull($subject->withLength(0)->mbstring('a', null));
		self::assertEquals('-', $subject->withLength(4)->mbstring('a', null));
		self::assertEquals('-', $subject->withLength(1, 4)->mbstring('a', null));
		self::assertNull($subject->withLength(20, 25)->mbstring('a', null));
	}
	
	public function test_string_WithExactLength_Multibyte()
	{
		$subject = new FromArray(['a' => '-']);
		
		self::assertNull($subject->withExactLength(0)->mbstring('a', null));
		self::assertNull($subject->withExactLength(15)->mbstring('a', null));
		self::assertEquals('-', $subject->withExactLength(1)->mbstring('a', null));
	}
	
	public function test_regex_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->regex('a', '/./', 'a'));
	}
	
	public function test_regex_ExistsAndValid_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->regex('a', '/b/', 'a'));
	}
	
	public function test_regex_ExistsAndNotValid_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('a', $subject->regex('a', '/a/', 'a'));
	}
	
	public function test_regex_RegexNotValid_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->regex('a', '[', 'a');
	}
	
	public function test_enum_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->enum('a', [], 'a'));
	}
	
	public function test_enum_ValuesArrayAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->enum('a', ['b'], 'a'));
	}
	
	public function test_enum_ValuesArrayAndNotExists_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('a', $subject->enum('a', ['c'], 'a'));
	}
	
	public function test_enum_ValuesNotStringOrArray_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', 1.1, 'a');
	}
	
	public function test_enum_ValuesNotClass_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', 'SomeString', 'a');
	}
	
	public function test_enum_ValuesNotTEnum_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', FromArrayTestHelper_A::class, 'a');
	}
	
	public function test_enum_ValuesTEnumAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->enum('a', FromArrayTestHelper_B::class, 'a'));
	}
	
	public function test_enum_ValuesTEnumAndNotExists_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'c']);
		
		self::assertEquals('a', $subject->enum('a', FromArrayTestHelper_B::class, 'a'));
	}
	
	public function test_requireInt_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->requireInt('a');
	}
	
	public function test_requireInt_ValueNotInt_ExceptionThrown()
    {
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => 'test']);
        
        $subject->requireInt('a');
    }
	
	public function test_requireInt_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 2]);
		
		self::assertEquals(2, $subject->requireInt('a'));
	}
	
	public function test_requireInt_WithBetween_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8]);
		
		$subject->between(10, 10)->requireInt('a');
	}
	
	public function test_requireInt_WithBetween_Success()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->between(2, 8)->requireInt('a'));
	}
	
	public function test_requireInt_WithGreaterThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8]);
		
		$subject->greaterThen(8)->requireInt('a');
	}
	
	public function test_requireInt_WithGreaterThen_Success()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->greaterThen(5)->requireInt('a'));
	}
	
	public function test_requireInt_WithLessThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8]);
		
		$subject->lessThen(2)->requireInt('a');
	}
	
	public function test_requireInt_WithLessThen_Success()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->lessThen(10)->requireInt('a'));
	}
	
	public function test_requireInt_WithGreaterOrEqualThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8]);
		
		$subject->greaterOrEqualThen(10)->requireInt('a');
	}
	
	public function test_requireInt_WithGreaterOrEqualThen_Success()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->greaterOrEqualThen(2)->requireInt('a'));
	}
	
	public function test_requireInt_WithLessOrEqualThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8]);
		
		$subject->lessOrEqualThen(2)->requireInt('a');
	}
	
	public function test_requireInt_WithLessOrEqualThen_Success()
	{
		$subject = new FromArray(['a' => 8]);
		
		self::assertEquals(8, $subject->lessOrEqualThen(10)->requireInt('a'));
	}
	
	public function test_requireBool_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->requireBool('a');
	}
	
	public function test_requireBool_ValueNotBool_ExceptionThrown()
    {
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => []]);
        
        $subject->requireBool('a');
    }
	
	public function test_requireBool_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 't']);
		
		self::assertTrue($subject->requireBool('a'));
	}
	
	public function test_requireFloat_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->requireFloat('a');
	}
	
	public function test_requireFloat_ValueNotFloat_ExceptionThrown()
    {
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => '2.a']);
        
        $subject->requireFloat('a');
    }
	
	public function test_requireFloat_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => '3.2']);
		
		self::assertEquals(3.2, $subject->requireFloat('a'));
	}
	
	public function test_requireFloat_WithBetween_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8.5]);
		
		$subject->between(10.1, 10.11)->requireFloat('a');
	}
	
	public function test_requireFloat_WithBetween_Success()
	{
		$subject = new FromArray(['a' => 8.5]);
		
		self::assertEquals(8.5, $subject->between(2, 8.5)->requireFloat('a'));
	}
	
	public function test_requireFloat_WithGreaterThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8.5]);
		
		$subject->greaterThen(8.5)->requireFloat('a');
	}
	
	public function test_requireFloat_WithGreaterThen_Success()
	{
		$subject = new FromArray(['a' => 8.5]);
		
		self::assertEquals(8.5, $subject->greaterThen(5.7)->requireFloat('a'));
	}
	
	public function test_requireFloat_WithLessThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8.5]);
		
		$subject->lessThen(2.4)->requireFloat('a');
	}
	
	public function test_requireFloat_WithLessThen_Success()
	{
		$subject = new FromArray(['a' => 8.5]);
		
		self::assertEquals(8.5, $subject->lessThen(10.2)->requireFloat('a'));
	}
	
	public function test_requireFloat_WithGreaterOrEqualThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8.5]);
		
		$subject->greaterOrEqualThen(10.44)->requireFloat('a');
	}
	
	public function test_requireFloat_WithGreaterOrEqualThen_Success()
	{
		$subject = new FromArray(['a' => 8.5]);
		
		self::assertEquals(8.5, $subject->greaterOrEqualThen(2.33)->requireFloat('a'));
	}
	
	public function test_requireFloat_WithLessOrEqualThen_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 8.5]);
		
		$subject->lessOrEqualThen(2.4)->requireFloat('a');
	}
	
	public function test_requireFloat_WithLessOrEqualThen_Success()
	{
		$subject = new FromArray(['a' => 8.5]);
		
		self::assertEquals(8.5, $subject->lessOrEqualThen(10.4)->requireFloat('a'));
	}
	
	public function test_require_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->require('a');
	}
	
	public function test_require_NotString_ExceptionThrown()
    {
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => []]);
        
        $subject->require('a');
    }
	
	public function test_require_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->require('a'));
	}
	
	public function test_require_WithWithLength_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 'test']);
		
		$subject->withLength(0)->require('a');
	}
	
	public function test_require_WithWithLength_Success()
	{
		$subject = new FromArray(['a' => 'test']);
		
		self::assertEquals('test', $subject->withLength(4)->require('a'));
	}
	
	public function test_require_WithWithExactLength_Fail()
	{
		$this->expectException(\WebCore\Exception\BadRequestException::class);
		
		$subject = new FromArray(['a' => 'test']);
		
		$subject->withExactLength(0)->require('a');
	}
	
	public function test_require_WithWithExactLength_Success()
	{
		$subject = new FromArray(['a' => 'test']);
		
		self::assertEquals('test', $subject->withExactLength(4)->require('a'));
	}
	
	public function test_requireRegex_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->requireRegex('a', '/./');
	}
	
	public function test_requireRegex_ExistsAndValid_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->requireRegex('a', '/b/'));
	}
	
	public function test_requireRegex_ExistsAndNotValid_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireRegex('a', '/a/');
	}
	
	public function test_requireRegex_RegexNotValid_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireRegex('a', '[');
	}
	
	public function test_requireEnum_NotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray([]);
		
		$subject->requireEnum('a', []);
	}
	
	public function test_requireEnum_ValuesArrayAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->requireEnum('a', ['b']));
	}
	
	public function test_requireEnum_ValuesArrayAndNotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireEnum('a', ['c']);
	}
	
	public function test_requireEnum_ValuesNotStringOrArray_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireEnum('a', 1.1);
	}
	
	public function test_requireEnum_ValuesNotClass_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireEnum('a', 'SomeString');
	}
	
	public function test_requireEnum_ValuesNotTEnum_ExceptionThrown()
	{
		$this->expectException(\WebCore\Exception\WebCoreFatalException::class);
		
		$subject = new FromArray(['a' => 'b']);
		
		$subject->requireEnum('a', FromArrayTestHelper_A::class);
	}
	
	public function test_requireEnum_ValuesTEnumAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->requireEnum('a', FromArrayTestHelper_B::class));
	}
	
	public function test_requireEnum_ValuesTEnumAndNotExists_ExceptionThrown()
	{
		$this->expectException(\Exception::class);
		
		$subject = new FromArray(['a' => 'c']);
		
		$subject->requireEnum('a', FromArrayTestHelper_B::class);
	}
	
	public function test_csv_NotExists_ReturnArrayInput()
	{
		$subject = new FromArray([]);
		
		self::assertInstanceOf(ArrayInput::class, $subject->csv('a'));
	}
	
	public function test_csv_ItemNotString_ReturnArrayInput()
	{
		$subject = new FromArray(['a' => ['a', 'b', 'c']]);
		
		self::assertInstanceOf(ArrayInput::class, $subject->csv('a'));
	}
	
	public function test_csv_Exists_ReturnArrayInput()
	{
		$subject = new FromArray(['a' => 'a,b,c']);
		
		self::assertInstanceOf(ArrayInput::class, $subject->csv('a'));
	}
	
	public function test_array_NotExists_ReturnArrayInput()
	{
		$subject = new FromArray([]);
		
		self::assertInstanceOf(ArrayInput::class, $subject->array('a'));
	}
	
	public function test_array_ItemNotArray_ReturnArrayInput()
	{
		$subject = new FromArray(['a' => 'a,b,c']);
		
		self::assertInstanceOf(ArrayInput::class, $subject->array('a'));
	}
	
	public function test_array_Exists_ReturnArrayInput()
	{
		$subject = new FromArray(['a' => ['a', 'b', 'c']]);
		
		self::assertInstanceOf(ArrayInput::class, $subject->array('a'));
	}
}


class FromArrayTestHelper_A {}

class FromArrayTestHelper_B 
{
	use TEnum;
	
	
	const B = 'b';
}