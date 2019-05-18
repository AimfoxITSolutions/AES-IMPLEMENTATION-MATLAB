
%function [x] = aes()
clear
clc
key_char = 'BabarHussainKhan';

%data_input = 'Howareyouiamnotabletoseeyouiwantyoutolearnmore';
data_input = input('Please Enter Data to encrypt');
len = length(data_input);
blocks = ceil(len/16);
 empty_text = (16*blocks)-len;
 for i=1:empty_text
     data_input = [data_input 'x'];
 end
b_s = 1;
b_e = 16;
for b = 1:blocks
    % key
    data_to_encrypt = data_input(1,b_s:b_e);
    key = getKey(key_char);
    % data
    state = getData(data_to_encrypt);
    % geting s_box and i_s_box
    [ s_box,i_s_box ] = SBox();
    % round zero
    [ state0 ] = RoundZero( state,key );
    % round 1 to 9
    [key9 state1 ] = Round19( state ,key ,s_box);
    % round 10
    [ cypher_state ] = Round10( state1,key9,s_box );
    % geting the getCypherText
    key;
    state
    [ plain_text ] = getCypherText( state )
    cypher_state
    [ cypher_text ] = getCypherText( cypher_state )
    b_s = b_s + 16;
    b_e = b_e + 16;
end
