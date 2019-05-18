function [state] = getData(data)

%UNTITLED Summary of this function goes here
%   Detailed explanation goes here


state = zeros(4);
a = 1;
for r=1:4
    for c=1:4
         temp = data(1,a);
         a = a + 1 ;
         state(c,r) = temp;
    end
end

end

