function [ sub_value ] = subsitute( value ,s_box )
%UNTITLED4 Summary of this function goes here
%   Detailed explanation goes here
value_hex = dec2hex(value);
 if(value >=0 && value < 16)
        i_r = 0;
        i_c = value;
 else       
        i_r = hex2dec(value_hex(1));
        % column for inverse value
        i_c = hex2dec(value_hex(2));
 end
        i_r = i_r + 1 ;
        i_c = i_c + 1 ;
sub_value = s_box(i_r,i_c);
end

