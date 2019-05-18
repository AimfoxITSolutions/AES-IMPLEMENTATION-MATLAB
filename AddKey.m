function [ new_state ] = AddKey(key , state )
%UNTITLED3 Summary of this function goes here
%   Detailed explanation goes here
%bitxor
for i=1:4
    new_state(:,i) = bitxor(key(:,i),state(:,i));
end
end

