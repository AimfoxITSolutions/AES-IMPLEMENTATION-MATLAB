function [key] = getKey(key_char)

%UNTITLED Summary of this function goes here
%   Detailed explanation goes here

key = zeros(4);
a = 1;
for r=1:4
    for c=1:4
         temp = key_char(1,a);
         a = a + 1 ;
         key(c,r) = temp;
    end
end

end

